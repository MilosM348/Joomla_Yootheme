<?php

namespace YpsApp\Source\CustomFieldsTypes;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Users\Administrator\Helper\UsersHelper;
use YOOtheme\Arr;
use function YOOtheme\app;
use function YOOtheme\trans;
use YOOtheme\Builder\Joomla\Fields\FieldsHelper;
use YOOtheme\Builder\Joomla\Source\ArticleHelper;
use YOOtheme\Builder\Source;
use YOOtheme\Config;
use YOOtheme\Event;
use YOOtheme\Path;
use YOOtheme\Str;

class FieldsType
{
    /**
     * @var string
     */
    protected $context;

    /**
     * Constructor.
     *
     * @param string $context
     */
    public function __construct($context)
    {
        $this->context = $context;
    }

    /**
     * @param Source $source
     * @param string $type
     * @param string $context
     * @param array  $fields
     *
     * @return array
     */
    public static function config(Source $source, $type, $context, array $fields)
    {


        $fields = [
            'fields' => array_filter(
                array_reduce(
                    $fields,
                    function ($fields, $field) use ($source, $type, $context) {

                        // $field->group_title
                        $field_group_title = trans('Custom Fields');
                        
                        return $fields +
                            static::configFields(
                                $field,
                                [
                                    'type' => 'String',
                                    'name' => strtr($field->name, '-', '_'),
                                    'metadata' => [
                                        'label' => $field->title,
                                        'group' => $field_group_title,
                                    ],
                                    'extensions' => [
                                        'call' => "YpsProduct.fields@resolve",
                                    ],
                                ],
                                $source,
                                $context,
                                $type
                            );
                    },
                    []
                )
            ),

            'extensions' => [
                'bind' => [
                    "YpsProduct.fields" => [
                        'class' => __CLASS__,
                        'args' => ['$context' => $context],
                    ],
                ],
            ],
        ];

        // dd($fields);

        return $fields;
    }

    protected static function configFields($field, array $config, Source $source, $context, $type)
    {
        $fields = [];

        $config = is_callable($callback = [__CLASS__, "config{$field->type}"])
            ? $callback($field, $config, $source, $context, $type)
            : static::configGenericField($field, $config);

        $fields[$field->name] = Event::emit(
            'source.com_fields.field|filter',
            $config,
            $field,
            $source,
            $context
        );

        if (is_callable($callback = [__CLASS__, "config{$field->type}String"])) {
            $config = $callback($field, $config, $source, $context, $type);
            $fields[$field->name . 'String'] = Event::emit(
                'source.com_fields.field|filter',
                $config,
                $field,
                $source,
                $context
            );
        }

        return $fields;
    }

    protected static function configGenericField($field, array $config)
    {
        if ($field->fieldparams->get('multiple')) {
            return ['type' => ['listOf' => 'YpsProductValueField']] + $config;
        }

        return $config;
    }

    protected static function configText($field, array $config)
    {
        return array_replace_recursive($config, ['metadata' => ['filters' => ['limit']]]);
    }

    protected static function configTextarea($field, array $config)
    {
        return array_replace_recursive($config, ['metadata' => ['filters' => ['limit']]]);
    }

    protected static function configEditor($field, array $config)
    {
        return array_replace_recursive($config, ['metadata' => ['filters' => ['limit']]]);
    }

    protected static function configCalendar($field, array $config)
    {
        return array_replace_recursive($config, ['metadata' => ['filters' => ['date']]]);
    }

    protected static function configUser($field, array $config)
    {
        return ['type' => 'User'] + $config;
    }

    protected static function configArticles($field, array $config)
    {
        return [
            'type' => $field->fieldparams->get('multiple') ? ['listOf' => 'YpsProduct'] : 'YpsProduct',
        ] + $config;
    }

    protected static function configRepeatable($field, array $config, Source $source)
    {
        $fields = [];

        foreach ((array) $field->fieldparams->get('fields') as $params) {
            $fields[$params->fieldname] = [
                'type' => $params->fieldtype === 'media' ? 'YpsProductMediaField' : 'String',
                'name' => Str::snakeCase($params->fieldname),
                'metadata' => [
                    'label' => $params->fieldname,
                    'group' => $field->group_title,
                    'filters' => !in_array($params->fieldtype, ['media', 'number'])
                        ? ['limit']
                        : [],
                ],
            ];
        }

        if ($fields) {
            $name = Str::camelCase(['Field', $field->name], true);
            $source->objectType($name, compact('fields'));

            return ['type' => ['listOf' => $name]] + $config;
        }
    }

    protected static function configSubform($field, array $config, Source $source, $context, $type)
    {
        $fields = [];

        foreach ((array) $field->fieldparams->get('options', []) as $option) {
            $subField = static::getSubfield($option->customfield, $context);

            if (!$subField) {
                continue;
            }

            $prefix = "{$field->name}_";
            $name = str_starts_with($subField->name, $prefix)
                ? substr($subField->name, strlen($prefix))
                : $subField->name;

            $fields += static::configFields(
                $subField,
                [
                    'type' => 'String',
                    'name' => Str::snakeCase($name),
                    'metadata' => [
                        'label' => $subField->title,
                        'group' => $field->title,
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => "YpsProduct.fields@resolveSubfield",
                            'args' => ['context' => $context, 'id' => $option->customfield],
                        ],
                    ],
                ],
                $source,
                $context,
                $type
            );
        }

        if ($fields = array_filter($fields)) {
            $name = Str::camelCase(['Field', $field->name], true);
            $source->objectType($name, compact('fields'));

            return ['type' => $field->fieldparams->get('repeat') ? ['listOf' => $name] : $name] +
                $config;
        }
    }

    protected static function configMedia($field, array $config)
    {
        return ['type' => 'YpsProductMediaField'] + $config;
    }

    protected static function configSql($field, array $config)
    {
        return [
            'type' => $field->fieldparams->get('multiple') ? ['listOf' => 'YpsProductSqlField'] : 'YpsProductSqlField',
        ] + $config;
    }

    protected static function configList($field, array $config)
    {
        return [
            'type' => $field->fieldparams->get('multiple')
                ? ['listOf' => 'YpsProductChoiceField']
                : 'YpsProductChoiceField',
        ] + $config;
    }

    protected static function configListString($field, array $config)
    {
        if (!$field->fieldparams->get('multiple')) {
            return;
        }

        $config['name'] .= 'String';

        return ['type' => 'YpsProductChoiceFieldString'] + $config;
    }

    protected static function configRadio($field, array $config)
    {
        return ['type' => 'YpsProductChoiceField'] + $config;
    }

    protected static function configCheckboxes($field, array $config)
    {
        return ['type' => ['listOf' => 'YpsProductChoiceField']] + $config;
    }

    protected static function configCheckboxesString($field, array $config)
    {
        $config['name'] .= 'String';

        return ['type' => 'YpsProductChoiceFieldString'] + $config;
    }

    public static function field($item, $args, $ctx, $info)
    {
        return $item;
    }

    public function resolve($item, $args, $ctx, $info)
    {
        $name = str_replace('String', '', strtr($info->fieldName, '_', '-'));

        if (!isset($item->id) || !($field = static::getField($name, $item, $this->context))) {
            return;
        }

        return $this->resolveField($field, $field->rawvalue);
    }

    public function resolveField($field, $value)
    {
        if (is_callable($callback = [$this, "resolve{$field->type}"])) {
            return $callback($field);
        }

        return $this->resolveGenericField($field, $value);
    }

    public function resolveGenericField($field, $value)
    {
        if ($field->fieldparams->exists('multiple')) {
            $value = (array) $value;

            if ($field->fieldparams['multiple']) {
                return array_map(function ($value) {
                    return is_scalar($value) ? compact('value') : $value;
                }, $value);
            } else {
                return array_shift($value);
            }
        }

        return $field->rawvalue;
    }

    public function resolveUser($field)
    {
        return Factory::getUser($field->rawvalue);
    }

    public function resolveArticles($field)
    {
        $ordering = $field->fieldparams->get('articles_ordering', 'ordering');
        $direction = $field->fieldparams->get('articles_ordering_direction', 'ASC');

        return $this->resolveGenericField(
            $field,
            ArticleHelper::get($field->rawvalue, [
                'order' => $ordering,
                'order_direction' => $direction,
            ])
        );
    }

    public function resolveRepeatable($field)
    {
        $fields = [];
        foreach ($field->fieldparams->get('fields', []) as $subField) {
            $fields[$subField->fieldname] = $subField->fieldtype;
        }

        return array_map(function ($vals) use ($fields) {
            $values = [];

            foreach ($vals as $name => $value) {
                if (Arr::get($fields, $name) === 'media') {
                    $values[Str::snakeCase($name)] = ['imagefile' => $value];
                } else {
                    $values[Str::snakeCase($name)] = $value;
                }
            }

            return $values;
        }, array_values(json_decode($field->rawvalue, true) ?: []));
    }

    public function resolveSubform($field)
    {
        return json_decode($field->rawvalue, true);
    }

    public function resolveSubfield($value, $args, $ctx, $info)
    {
        $subfield = clone static::getSubfield($args['id'], $this->context);

        if (!$subfield || empty($value["field{$args['id']}"])) {
            return;
        }

        $subfield->rawvalue = $subfield->value = $value["field{$args['id']}"];

        return $this->resolveField($subfield, $subfield->rawvalue);
    }

    public function resolveList($field)
    {
        return $this->resolveSelect($field, $field->fieldparams->get('multiple'));
    }

    public function resolveCheckboxes($field)
    {
        return $this->resolveSelect($field, true);
    }

    public function resolveRadio($field)
    {
        return $this->resolveSelect($field);
    }

    public function resolveSelect($field, $multiple = false)
    {
        $result = [];

        foreach ($field->fieldparams->get('options', []) as $option) {
            if (in_array($option->value, (array) $field->rawvalue ?: [])) {
                if ($multiple) {
                    $result[] = $option;
                    continue;
                }

                return $option;
            }
        }

        return $result;
    }

    public function resolveImagelist($field)
    {
        $config = app(Config::class);
        $root = Path::relative(
            $config('app.rootDir'),
            "{$config('app.uploadDir')}/{$field->fieldparams->get('directory')}"
        );

        return $this->resolveGenericField(
            $field,
            array_map(
                function ($value) use ($root) {
                    return "{$root}/{$value}";
                },
                array_filter((array) $field->rawvalue, function ($value) {
                    return $value && $value != -1;
                })
            )
        );
    }

    public function resolveMedia($field)
    {
        $value = $field->rawvalue;

        if (is_array($value)) {
            return $value;
        }

        if (!is_string($value)) {
            return;
        }

        if (str_starts_with($value, '{')) {
            return json_decode($value, true);
        }

        return ['imagefile' => $value, 'alt_text' => ''];
    }

    public function resolveUsergrouplist($field)
    {
        return $this->resolveGenericField(
            $field,
            array_intersect_key($this->getUserGroups(), array_flip((array) $field->rawvalue))
        );
    }

    public function resolveSql($field)
    {
        if ($field->rawvalue === '') {
            return;
        }

        $db = Factory::getDbo();
        $query = $field->fieldparams->get('query', '');
        $condition = array_reduce((array) $field->rawvalue, function ($carry, $value) use ($db) {
            return $value ? $carry . ", {$db->q($value)}" : $carry;
        });

        // Run the query with a having condition because it supports aliases
        $db->setQuery(
            'SELECT value, text FROM (' .
                $query .
                ') as a having value in (' .
                trim($condition, ',') .
                ')'
        );

        try {
            $items = $db->loadObjectList();

            return $field->fieldparams->get('multiple') ? $items : array_pop($items);
        } catch (\Exception $e) {
            Event::emit('source.error', [$e]);
            return;
        }
    }

    protected function getUserGroups()
    {
        $data = [];

        foreach (UsersHelper::getGroups() as $group) {
            $data[$group->value] = Text::_(preg_replace('/^(- )+/', '', $group->text));
        }

        return $data;
    }

    public static function getField($name, $item, $context)
    {
        $fields = static::getFields($item, $context);

        return isset($fields[$name]) ? $fields[$name] : null;
    }

    protected static function getFields($item, $context)
    {
        if (!isset($item->_fields)) {
            PluginHelper::importPlugin('fields');

            $item->_fields = [];

            foreach (
                isset($item->jcfields) ? $item->jcfields : FieldsHelper::getFields($context, $item)
                as $field
            ) {
                if (!isset($item->jcfields)) {
                    Factory::getApplication()->triggerEvent('onCustomFieldsBeforePrepareField', [
                        $context,
                        $item,
                        &$field,
                    ]);
                }

                $item->_fields[$field->name] = $field;
            }
        }

        return $item->_fields;
    }

    protected static function getSubfield($id, $context)
    {
        static $fields = [];

        if (!isset($fields[$context])) {
            $fields[$context] = [];
            foreach (FieldsHelper::getFields($context, null, true) as $field) {
                $fields[$context][$field->id] = $field;
            }
        }

        return !empty($fields[$context][$id]) ? $fields[$context][$id] : null;
    }
}
