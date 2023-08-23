<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use Awobaz\Compoships\Compoships;


class Bbs_tbl extends Model
{
    use SoftDeletes;
    use Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbs_tbl';
    protected $primaryKey = 'sid';
    protected $with = [
        // 'Bbs_image'
        // , 'Bbs_files2'
    ];
    // public $timestamps = true;
    // protected $dateFormat = 'U';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $fillable = [
        'bbs_name'
        , 'type'
        , 'user_id'
        , 'name'
        , 'email'
        , 'is_notice'
        , 'is_push'
        , 'title'
        , 'content'
        , 'link_url'
        , 'read_count'
        , 'link_click_count'
        , 'is_pop'
        , 'template'
        , 'pop_content_type'
        , 'pop_size_w'
        , 'pop_size_h'
        , 'pop_size_y'
        , 'pop_size_x'
        , 'pop_detail'
        , 'pop_resize'
        , 'pop_sdate'
        , 'pop_edate'
        , 'pop_content'
        , 'status'
    ];

    protected $attributes = [
    //     'is_notice' => 'N'
    //     , 'is_push' => 'N'
        'read_count' => 0
        , 'link_click_count' => 0
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeBbsName( $query, $value ){
        return $query->where('bbs_name', $value);
    }

    public function scopeIsNotice( $query, $value ){
        return $query->where('is_notice', $value);
    }

    public function scopeLikeTitle( $query, $value ){
        return $query->where('title', 'like', '%'.$value.'%');
    }

    public function scopeLikeContent( $query, $value ){
        return $query->where('content', 'like', '%'.$value.'%');
    }

    public function scopeOrderbyCreatedAt( $query, $value ){
        return $query->orderby('created_at', $value);
    }

    /**
     * Get all of the post's attachments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bbs_files()
    {
        return $this->hasMany(Bbs_files::class, ['fid', 'bbs_name'], ['sid', 'bbs_name']);
    }
    public function Bbs_image()
    {
        return $this->Bbs_files()->where('type', 1);
    }

    public function Bbs_files2()
    {
        return $this->Bbs_files()->where('type', 2);
    }

    // create할때 created_at , updated_at 같이 값들어가는거 updated_at 비활성화 
    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

    public function createBbs( $posts ){
        //11222
        DB::beginTransaction();
        try {

            $bbs_tbl = new Bbs_tbl;
            foreach( $bbs_tbl->fillable as $key => $val ){
                if( array_key_exists( $val, $posts) !== false ){
                    $bbs_tbl[$val] = $posts[$val];
                }
            }

            $bbs_tbl->save();

            // $bbs_tbl = Bbs_tbl::create([
            //     'bbs_name'              => $posts['bbs_name']
            //     , 'user_id'             => $posts['user_id']
            //     , 'name'                => $posts['name']
            //     // , 'email'               => $request->cookie('email') ?? null
            //     , 'title'               => $posts['title']
            //     , 'is_notice'           => $posts['is_notice'] ?? 'N'
            //     , 'is_push'             => $posts['is_push'] ?? 'N'
            //     , 'status'              => $posts['status']
            //     , 'link_url'            => $posts['link_url']
            //     , 'content'             => $posts['content']
            //     , 'is_pop'              => $posts['is_pop']
            //     , 'template'            => $posts['template']
            //     , 'pop_content_type'    => $posts['pop_content_type']
            //     , 'pop_size_w'          => $posts['pop_size_w']
            //     , 'pop_size_h'          => $posts['pop_size_h'] 
            //     , 'pop_size_y'          => $posts['pop_size_y'] 
            //     , 'pop_size_x'          => $posts['pop_size_x'] 
            //     , 'pop_detail'          => $posts['pop_detail'] 
            //     , 'pop_resize'          => $posts['pop_resize'] 
            //     , 'pop_sdate'           => $posts['pop_sdate'] ?? null
            //     , 'pop_edate'           => $posts['pop_edate'] ?? null
            //     , 'pop_content'         => $posts['pop_content'] ?? null
            // ]);
    
            if ( (int)$posts['plupload_count'] > 0 ) {
                for ( $i = 0 ; $i < (int)$posts['plupload_count'] ; $i++) {
                    if ( $posts['plupload_'.$i.'_status'] === 'done') {
                        $bbs_files = $bbs_tbl->bbs_files()->make();
    
                        $bbs_files->type = config('site.bbs.'.$bbs_name.'.type');
                        $bbs_files->path = $posts['plupload_'.$i.'_stored_path'];
                        $bbs_files->filename = $posts['plupload_' . $i . '_name'];
                        $bbs_files->bbs_name = $bbs_name;
                        $bbs_files->fid = $bbs_tbl->sid;
                        $bbs_files->created_at = time();
    
                        $bbs_files->save();
    
                    }
                }
            }
        } catch ( Exception $e ) {
            DB::rollback();
            return [ 
                'status' => 400     
                , 'msg' => $e
            ];
        }
        DB::commit();

        return [ 
            'status' => 201     
            , 'msg' => '글이 등록되었습니다.'
        ];
        
    }

    public function updateBbs( $posts, $bbs_name, $sid ){
        
        $bbs_tbl = Bbs_tbl::find($sid);

        if( !$bbs_tbl ){
            return [ 
                'status' => 400     
                , 'msg' => '해당 글이 존재하지 않습니다.'
            ];
        }

        DB::beginTransaction();
        try {

            foreach( $bbs_tbl->fillable as $key => $val ){
                if( array_key_exists( $val, $posts) !== false ){
                    $bbs_tbl[$val] = $posts[$val];
                }
            }

            $bbs_tbl->save();

            $bbs_tbl->update([
                'bbs_name'              => $posts['bbs_name']
                , 'user_id'             => $posts['user_id']
                , 'name'                => $posts['name']
                // , 'email'               => $request->cookie('email') ?? null
                , 'title'               => $posts['title']
                , 'is_notice'           => $posts['is_notice'] ?? 'N'
                , 'is_push'             => $posts['is_push'] ?? 'N'
                , 'status'              => $posts['status']
                , 'link_url'            => $posts['link_url']
                , 'content'             => $posts['content']
                , 'is_pop'              => $posts['is_pop']
                , 'template'            => $posts['template']
                , 'pop_content_type'    => $posts['pop_content_type']
                , 'pop_size_w'          => $posts['pop_size_w']
                , 'pop_size_h'          => $posts['pop_size_h'] 
                , 'pop_size_y'          => $posts['pop_size_y'] 
                , 'pop_size_x'          => $posts['pop_size_x'] 
                , 'pop_detail'          => $posts['pop_detail'] 
                , 'pop_resize'          => $posts['pop_resize'] 
                , 'pop_sdate'           => $posts['pop_sdate'] ?? null
                , 'pop_edate'           => $posts['pop_edate'] ?? null
                , 'pop_content'         => $posts['pop_content'] ?? null
            ]);
    
            $delete_files = $posts['delete_files'] ?? null;
            if (is_array($delete_files) && !empty($delete_files)) {
                $bbsFiles = Bbs_files::find($delete_files);

                \App\Http\Controllers\File\FileController::file_delete($bbsFiles);
                foreach( $bbsFiles as $files ){
                    $files->delete();
                }
            }

            if ( (int)$posts['plupload_count'] > 0 ) {
                for ( $i = 0 ; $i < (int)$posts['plupload_count'] ; $i++) {
                    if ( $posts['plupload_'.$i.'_status'] === 'done') {
                        $bbs_files = $bbs_tbl->bbs_files()->make();
    
                        $bbs_files->type = config('site.bbs.'.$bbs_name.'.type');
                        $bbs_files->path = $posts['plupload_'.$i.'_stored_path'];
                        $bbs_files->filename = $posts['plupload_' . $i . '_name'];
                        $bbs_files->bbs_name = $bbs_name;
                        $bbs_files->fid = $bbs_tbl->sid;
                        $bbs_files->created_at = time();
    
                        $bbs_files->save();
    
                    }
                }
            }
        } catch ( Exception $e ) {
            DB::rollback();
            return [ 
                'status' => 400     
                , 'msg' => $e
            ];
        }
        DB::commit();

        return [ 
            'status' => 200     
            , 'msg' => '글이 수정 되었습니다.'
        ];
        
    }

    public function deleteBbs( $bbs_name, $sid ){

        $bbs_tbl = Bbs_tbl::find($sid);

        DB::beginTransaction();
        try {
            if ( $bbs_tbl->Bbs_files->isNotEmpty() ) {
                foreach ( $bbs_tbl->Bbs_files as $key => $val ){
                    \Storage::delete($val->path);
                }
                $bbs_tbl->Bbs_files->each->delete();
            } 
            $bbs_tbl->delete();
        } catch ( Exception $e ) {
            DB::rollback();
            return [ 
                'status' => 400     
                , 'msg' => $e
            ];
        }
        DB::commit();

        return [ 
            'status' => 200     
            , 'msg' => '삭제 되었습니다.'
        ];

    }

    public function changeBbs( $bbs_name, $sid, $status ){

        $bbs_tbl = Bbs_tbl::find($sid);

        DB::beginTransaction();
        try {
            $bbs_tbl->update([
                'status'    => $status
            ]);
        } catch ( Exception $e ) {
            DB::rollback();
            return [ 
                'status' => 400     
                , 'msg' => $e
            ];
        }
        DB::commit();

        return [ 
            'status' => 200     
            , 'msg' => '변경 되었습니다.'
        ];

    }

//    public function hasPermission($permission)
//    {
//        $is_admin = config('site.post.' . $this->bbs_name . '.permission.admin')();
//
//        switch ($permission) {
//            case 'create':
//            case 'store':
//                return !$this->is_notice && config('site.post.' . $this->bbs_name . '.use_reply') && ($is_admin || config('site.post.' . $this->bbs_name . '.permission.create')());
//            case 'edit':
//            case 'update':
//            case 'destroy':
//                return $is_admin || (\Auth::check() && $this->user_id === \Auth::id());
//            case 'index':
//            case 'show':
//                return $is_admin || config('site.post.' . $this->bbs_name . '.permission.show')();
//            default:
//                $permission_func = config('site.post.' . $this->bbs_name . '.permission.' . $permission);
//
//                if (is_null($permission_func)) {
//                    return false;
//                } else {
//                    return $is_admin || $permission_func();
//                }
//        }
//    }

}