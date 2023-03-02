<?php

namespace YpsApp_Gallery\Source;

class SourceListener
{
    public static function initSource($source)
    {

        $source->queryType(YpsGallery\YpsGalleryQueryType::config());
        $source->objectType('YpsGallery', YpsGallery\YpsGallery::config());

    }


}
