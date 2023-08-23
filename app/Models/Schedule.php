<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Awobaz\Compoships\Compoships;

use App\Models\Bbs_files;

class Schedule extends Model
{
    use SoftDeletes;
    use Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedule_tbl';
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
        , 'subject'
        , 'gubun'
        , 'email'
        , 'date_type'
        , 'sdate'
        , 'edate'
        , 'place'
        , 'sponsor'
        , 'inquiry'
        , 'linkurl'
        , 'read_count'
    ];

    protected $attributes = [
        // 'read_count' => 0
        // , 'link_click_count' => 0
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bbs_files()
    {
        return $this->hasMany( Bbs_files::class, ['fid', 'bbs_name'], ['sid', 'bbs_name'] );
    }

    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

    public function createBbs( $posts ){

        DB::beginTransaction();
        try {

            $schedule = new Schedule;
            foreach( $schedule->fillable as $key => $val ){
                if( array_key_exists( $val, $posts) !== false ){
                    $schedule[$val] = $posts[$val];
                }
            }

            $schedule->save();
    
            if ( (int)$posts['plupload_count'] > 0 ) {
                for ( $i = 0 ; $i < (int)$posts['plupload_count'] ; $i++) {
                    if ( $posts['plupload_'.$i.'_status'] === 'done') {
                        $bbs_files = $schedule->bbs_files()->make();
    
                        $bbs_files->type = config('site.bbs.'.$posts['bbs_name'].'.type');
                        $bbs_files->path = $posts['plupload_'.$i.'_stored_path'];
                        $bbs_files->filename = $posts['plupload_' . $i . '_name'];
                        $bbs_files->bbs_name = $posts['bbs_name'];
                        $bbs_files->fid = $schedule->sid;
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

    public function updateBbs( $posts ){
        
        $schedule = Schedule::find( $posts['sid'] );

        if( !$schedule ){
            return [ 
                'status' => 400     
                , 'msg' => '해당 글이 존재하지 않습니다.'
            ];
        }

        DB::beginTransaction();
        try {

            foreach( $schedule->fillable as $key => $val ){
                if( array_key_exists( $val, $posts) !== false ){
                    $schedule[$val] = $posts[$val];
                }
            }

            $schedule->save();
    
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
                        $bbs_files = $schedule->bbs_files()->make();
    
                        $bbs_files->type = config('site.bbs.'.$bbs_name.'.type');
                        $bbs_files->path = $posts['plupload_'.$i.'_stored_path'];
                        $bbs_files->filename = $posts['plupload_' . $i . '_name'];
                        $bbs_files->bbs_name = $bbs_name;
                        $bbs_files->fid = $schedule->sid;
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

    public function deleteBbs( $sid ){

        $bbs_tbl = Schedule::find($sid);

        DB::beginTransaction();
        try {
            if ( $bbs_tbl->bbs_files->isNotEmpty() ) {
                foreach ( $bbs_tbl->bbs_files as $key => $val ){
                    \Storage::delete($val->path);
                }
                $bbs_tbl->bbs_files->each->delete();
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


    public function calenderDatas( $request, $posts ){

        if( $request->query('year') && $request->query('month') ){
            $dt = Carbon::create($request->query('year'), $request->query('month'), 1);
            $startYmd = $dt->startOfMonth()->toDateString();
        } else {
            // 현재 시간
            $dt = Carbon::now();
            $startYmd = $dt->startOfMonth()->toDateString();
        }

        $endYmd = $dt->endOfMonth()->toDateString();

        if ( $request->has(['search_column', 'search_value']) ) {
            $posts = $posts->where(function ($query) use ($request) {
                $search_value = $request->query('search_value');
                foreach (explode('+', $request->query('search_column')) as $search_column) {
                    $query = $query->orWhere($search_column, 'LIKE', '%' . $search_value . '%');
                }
            });
        }

        $posts = $posts->where(function($query) use ($startYmd, $endYmd ) {
            $query->whereDate('sdate', '>=', $startYmd)
                ->whereDate('sdate', '<=', $endYmd)
                ->orwhereDate('edate', '>=', $startYmd)
                ->whereDate('edate', '<=', $endYmd);
        });
        $posts = $posts->get();

        $search_date = Carbon::now();
        if($request->query('year') && $request->query('month')) {
            $search_date =  Carbon::create($request->query('year'), $request->query('month'));
            $date = [
                'year'          => Carbon::parse($search_date)->format('Y'),
                'month'         => Carbon::parse($search_date)->format('m'),
                'prev_year'     => Carbon::parse($search_date)->subMonth(1)->startOfMonth()->format('Y'),
                'prev_month'    => Carbon::parse($search_date)->subMonth(1)->startOfMonth()->format('m'),
                'next_year'     => Carbon::parse($search_date)->addMonth(1)->startOfMonth()->format('Y'),
                'next_month'    => Carbon::parse($search_date)->addMonth(1)->startOfMonth()->format('m'),
                'start_date'    => Carbon::parse($search_date)->startOfMonth()->toDateString(), //시작일
                'end_date'      => Carbon::parse($search_date)->endOfMonth()->toDateString(), // 종료일
            ];
        } else {
            $date = [
                'year'          => Carbon::parse($search_date)->format('Y'),
                'month'         => Carbon::parse($search_date)->format('m'),
                'prev_year'     => Carbon::parse($search_date)->subMonth(1)->startOfMonth()->format('Y'),
                'prev_month'    => Carbon::parse($search_date)->subMonth(1)->startOfMonth()->format('m'),
                'next_year'     => Carbon::parse($search_date)->addMonth(1)->startOfMonth()->format('Y'),
                'next_month'    => Carbon::parse($search_date)->addMonth(1)->startOfMonth()->format('m'),
                'start_date'    => Carbon::parse($search_date)->startOfMonth()->toDateString(), //시작일
                'end_date'      => Carbon::parse($search_date)->endOfMonth()->toDateString(), // 종료일
            ];
        }

        $date['date']       = date('Y-m-d');
        $date['maxDay']     = date("t", strtotime( $date['start_date']) ); 
        $date['startDay']   = date("w", strtotime( $date['start_date']) ); 
        $date['endDay']     = date("w", strtotime( $date['end_date']) ); 
        $date['maxWeek']    = ceil(( $date['maxDay'] + $date['startDay'] ) / 7); 
        $date['day']        = 1;

        $datas = [
            'date' => $date,
            'posts' => $posts
        ];

        return $datas;

    }

}