<?php 

namespace Config\Mapper;

use AutoMapperPlus\CustomMapper\CustomMapper;

class LowerCaseMapper extends CustomMapper
{

    public function mapToObject($source, $destination)
    {
        $keys = array_keys((array)$source);

        foreach ($keys as $key) {
            $destination->{strtolower($key)} = $source->{$key};
        }

        return $destination;
    }
}
?>