<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\pt_BR;

require_once "check_digit.php";

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}} {{lastName}}',
        '{{firstNameMale}} {{lastName}} {{suffix}}',
        '{{firstNameMale}} {{firstNameMale}} {{lastName}} {{suffix}}',
        '{{firstNameMale}} {{lastName}} {{lastName}} {{suffix}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}} {{suffix}}',
        '{{titleMale}} {{firstNameMale}} {{firstNameMale}} {{lastName}} {{suffix}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}} {{lastName}} {{suffix}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{firstNameFemale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}} {{suffix}}',
        '{{firstNameFemale}} {{firstNameFemale}} {{lastName}} {{suffix}}',
        '{{firstNameFemale}} {{lastName}} {{lastName}} {{suffix}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}} {{suffix}}',
        '{{titleFemale}} {{firstNameFemale}} {{firstNameFemale}} {{lastName}} {{suffix}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}} {{lastName}} {{suffix}}',
    );

    protected static $firstNameMale = array(
        'Aaron', 'Adriano', 'Alan', 'Alexandre', 'Alonso', 'Anderson', 'Andres', 'Ant??nio', 'Benjamin', 'Bruno', 'Camilo', 'Carlos', 'Christian',
        'Christopher', 'Crist??v??o', 'Daniel', 'Dante', 'David', 'Diego', 'Eduardo', 'Elias', 'Emanuel', 'Emiliano', 'Em??lio', 'Est??v??o',
        'Evandro', 'Everton', 'Felipe', 'Fernando', 'Francisco', 'Franco', 'F??bio', 'Gabriel', 'Gian', 'Guilherme', 'Gustavo', 'Henrique',
        'Hernani', 'Hor??cio', 'Hugo', 'Ian', 'In??cio', 'Isaac', 'Ivan', 'Jer??nimo', 'Joaquin', 'Jorge', 'Josu??', 'Jos??',
        'Jo??o', 'Kevin', 'Leandro', 'Leonardo', 'Lucas', 'Luciano', 'Luis', 'Manuel', 'Mateus', 'Matias', 'Miguel', 'M??rio',
        'M??ximo', 'Noel', 'Pablo', 'Paulo', 'Pedro', 'Rafael', 'Ricardo', 'Rodrigo', 'Samuel', 'Santiago', 'Simon', 'S??rgio',
        'Thales', 'Thiago', 'Tom??s', 'Valentin', 'Vicente', 'Agostinho', 'Demian', 'Giovane', 'J??como', 'Martinho', 'Maximiano', 'Natal', 'Sebasti??o',
        'Sim??o', 'Teobaldo', 'Ziraldo'
    );

    protected static $firstNameFemale = array(
        'Abril', 'Adriana', 'Agustina', 'Alessandra', 'Alexa', 'Allison', 'Alma', 'Amanda', 'Am??lia', 'Ana', 'Andrea', 'Antonieta', 'Ariadna',
        'Ariana', 'Ashley', 'Beatriz', 'Bianca', 'Camila', 'Carla', 'Carolina', 'Catarina', 'Clara', 'Daniela', 'Elizabeth', 'Em??lia',
        'Fabiana', 'F??tima', 'Gabriela', 'Giovana', 'Helena', 'Irene', 'Isabel', 'Isabella', 'Isadora', 'Ivana', 'Jasmin', 'Joana',
        'Josefina', 'Juliana', 'Julieta', 'J??lia', 'Ketlin', 'Laura', 'Luana', 'Luara', 'Luciana', 'Luna', 'Luzia', 'Madalena',
        'Mait??', 'Malena', 'Manuela', 'Mariana', 'Mel', 'Melissa', 'Mia', 'Micaela', 'Michele', 'Miranda', 'Nat??lia', 'Nicole',
        'Noel??', 'Norma', 'N??dia', 'Ol??via', 'Ornela', 'Paula', 'Paulina', 'P??mela', 'Rafaela', 'Rebeca', 'Regina', 'Renata',
        'Sabrina', 'Salom??', 'Samanta', 'Sara', 'Silvana', 'Sofia', 'Sophie', 'Suzana', 'Ta??s', 'T??bata', 'Valentina', 'Val??ria',
        'Violeta', 'Vit??ria', 'Abgail', 'Const??ncia', 'Hort??ncia', 'Tess??lia', 'Thalissa'
    );

    protected static $lastName = array(
        'Abreu', 'Azevedo', 'Aguiar', 'Arag??o', 'Assun????o', 'Aranda', '??vila',
        'Balestero', 'Barreto', 'Barros', 'Batista', 'Bezerra', 'Beltr??o',
        'Benites', 'Bittencourt', 'Branco', 'Bonilha', 'Brito', 'Burgos',
        'Caldeira', 'Camacho', 'Campos', 'Carmona', 'Carrara', 'Casanova',
        'Chaves', 'Cervantes', 'Cola??o', 'Cordeiro', 'Corona', 'Correia',
        'Cort??s', 'Cruz', 'D\'??vila', 'Delatorre', 'Delgado', 'Delvalle',
        'Dias', 'Domingues', 'Dominato', 'Duarte', 'Escobar', 'Espinoza',
        'Esteves', 'Estrada', 'Faria', 'Faro', 'Feliciano', 'Ferminiano',
        'Fernandes', 'Ferraz', 'Ferreira', 'Fidalgo', 'Furtado',
        'Ferreira', 'Flores', 'Fonseca', 'Franco', 'Fontes', 'Galindo',
        'Galhardo', 'Galv??o', 'Garcia', 'Gil', 'God??i', 'Gomes', 'Gon??alves',
        'Grego', 'Guerra', 'Gusm??o', 'Jimenes', 'Leal', 'Leon', 'Lira',
        'Lovato', 'Lozano', 'Lutero', 'Madeira', 'Maldonado', 'Mar??s', 'Marin',
        'Marinho', 'Marques', 'Martines', 'Mascarenhas', 'Matias', 'Matos',
        'Maia', 'Medina', 'Meireles', 'Mendes', 'Mendon??a', 'Molina',
        'Montenegro', 'Neves', 'Oliveira', 'Ortega', 'Ortiz', 'Quintana',
        'Queir??s',  'Pacheco', 'Padilha', 'Padr??o', 'Paes', 'Paz', 'Pedrosa',
        'Pena', 'Pereira', 'Perez', 'Prado', 'Pontes', 'Quintana', 'Queir??s',
        'Ramires', 'Ramos', 'Rangel', 'Rezende', 'Reis', 'Rico', 'Rios',
        'Rivera', 'Rocha', 'Rodrigues', 'Romero', 'Roque', 'Rosa', 'Salas',
        'Salazar', 'Sales', 'Salgado', 'Sanches', 'Sandoval', 'Santacruz',
        'Santana', 'Santiago', 'Saraiva', 'Sep??lveda', 'Serna', 'Serra',
        'Serrano', 'Soares', 'Solano', 'Soto', 'Tamoio', 'Teles', 'Toledo',
        'Torres', 'Uchoa', 'Urias', 'Valdez', 'Val??ncia', 'Valentin', 'Vale',
        'Vasques', 'Vega', 'Velasques', 'Verdugo', 'Verdara', 'Vieira', 'Vila',
        'Zamana', 'Zambrano', 'Zarago??a', 'da Cruz', 'da Rosa', 'da Silva',
        'das Dores', 'das Neves', 'de Aguiar', 'de Oliveira', 'de Souza'
    );

    protected static $titleMale = array('Sr.', 'Dr.',);

    protected static $titleFemale = array('Sra.', 'Srta.', 'Dr.',);

    protected static $suffix = array('Filho', 'Neto', 'Sobrinho', 'Jr.');

    /**
     * @example 'Jr.'
     */
    public static function suffix()
    {
        return static::randomElement(static::$suffix);
    }

    /**
     * A random CPF number.
     * @link http://en.wikipedia.org/wiki/Cadastro_de_Pessoas_F%C3%ADsicas
     * @param bool $formatted If the number should have dots/dashes or not.
     * @return string
     */
    public function cpf($formatted = true)
    {
        $n = $this->generator->numerify('#########');
        $n .= check_digit($n);
        $n .= check_digit($n);

        return $formatted? vsprintf('%d%d%d.%d%d%d.%d%d%d-%d%d', str_split($n)) : $n;
    }

    /**
     * A random RG number, following Sao Paulo state's rules.
     * @link http://pt.wikipedia.org/wiki/C%C3%A9dula_de_identidade
     * @param bool $formatted If the number should have dots/dashes or not.
     * @return string
     */
    public function rg($formatted = true)
    {
        $n = $this->generator->numerify('########');
        $n .= check_digit($n);

        return $formatted? vsprintf('%d%d.%d%d%d.%d%d%d-%s', str_split($n)) : $n;
    }
}
