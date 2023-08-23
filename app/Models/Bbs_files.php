<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Awobaz\Compoships\Compoships;

class Bbs_files extends Model
{
    use SoftDeletes;
    use Compoships;
    
    protected $primaryKey = 'sid';

    public $timestamps = false;
    protected $dateFormat = 'U';
    public function getIconUrl()
    {
        $type = 'etc';

        $extensions = ['avi', 'doc', 'docx', 'ppt', 'pptx', 'exe', 'gif', 'jpg', 'hwp', 'pdf', 'mp3', 'wav', 'xls', 'xlsx', 'zip', 'alz'];

        $file_extension = \File::extension($this->filename);

        if (in_array($file_extension, $extensions)) {
            $type = $file_extension;
        }

        return asset('image/icon/icon_' . $type . '.gif');
    }
}
