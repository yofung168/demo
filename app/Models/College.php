<?php

namespace App\Models;


class College extends CommonModel
{
    //
    protected $table = 'colleges';

    public static function createData($data)
    {
        $school_id = $data['school_id'];
        $info = self::where(['school_id' => $school_id])->first();
        if (is_null($info)) {
            self::create($data);
        } else {
            foreach ($data as $field => $value) {
                $info->{$field} = $value;
            }
            $info->updated_at = date('Y-m-d H:i:s');
            $info->save();
        }
        return true;
    }
}
