<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\Photo;


class PhotoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:photo-view|photo-create|photo-update|photo-delete', ['only' => ['index']]);
        $this->middleware('permission:photo-create', ['only' => ['create','store']]);
        $this->middleware('permission:photo-update', ['only' => ['edit','update']]);
        $this->middleware('permission:photo-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Photo';
        $info=new stdClass();
        $info->title = 'Photos';
        $info->first_button_title = 'Add Photo';
        $info->first_button_route = 'admin.photos.create';
        $info->route_index = 'admin.photos.index';
        $info->description = 'These all are Photos';


        $with_data=[];

        $data = Photo::query();

        

        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->get();

        return view('admin.photos.index', compact('page_title', 'data', 'info'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Photo Create';
        $info=new stdClass();
        $info->title = 'Photos';
        $info->first_button_title = 'All Photo';
        $info->first_button_route = 'admin.photos.index';
        $info->form_route = 'admin.photos.store';

        return view('admin.photos.create',compact('page_title','info'));
    }


    public function store(Request $request)
    {

        // dd($request->all());
        
        $validation_rules=[
           'unique_id' => 'required',

           'main_photo' => 'required',
           'banners' => 'required|array',
           'banners*' => 'required|array',
           'damage' => 'required|array',
           'damage*' => 'required|array',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = new Photo;
        
        $row->cloth_id = $request->unique_id;
    

        if($request->hasfile('banner')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('banner'),
                'storage/Photos',
                ['png','jpg','jpeg','gif']
            );

            if(isset($file_response['result']) && !$file_response['result'])
            {
                
                return back()->with('warning',$file_response['message']);
            }

            $row->banner = $file_response['filename'];
        }


        $row->save();
        
        return redirect()->route('admin.photos.index')
        ->with('success','Photo created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Photo Details';
        $info = new stdClass();
        $info->title = 'Photos Details';
        $info->form_route = 'admin.photos.update';
        $info->first_button_title = 'Edit Photo';
        $info->first_button_route = 'admin.photos.edit';
        $info->second_button_title = 'All Photo';
        $info->second_button_route = 'admin.photos.index';
        $info->description = '';


        $data = Photo::findOrFail($id);


        return view('admin.photos.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Photo Edit';
        $info=new stdClass();
        $info->title = 'Photos';
        $info->first_button_title = 'Add Photo';
        $info->first_button_route = 'admin.photos.create';
        $info->second_button_title = 'All Photo';
        $info->second_button_route = 'admin.photos.index';
        $info->form_route = 'admin.photos.update';
        $info->route_destroy = 'admin.photos.destroy';

        $data=Photo::where('id',$id)->first();

        return view('admin.photos.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('photos', 'slug')->ignore($id),
            ],
                    
            'meta_title' => 'nullable|string',
                    
            'meta_tags' => 'nullable|string',
                    
            'blog_category_id' => 'required|integer',
                    
            'status' => 'required|string|in:draft,published',
                    
            'short_description' => 'nullable|string',
                    
            'description' => 'nullable|string',
                    
            'meta_description' => 'nullable|string',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = Photo::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        $row->title=$request->title;
        
        $row->slug=$request->slug;
        
        $row->meta_title=$request->meta_title;
        
        $row->meta_tags=$request->meta_tags;
        
        $row->short_description=$request->short_description;
        
        $row->description=$request->description;
        
        $row->meta_description=$request->meta_description;
        
        $row->blog_category_id=$request->blog_category_id;
        
        $row->status=$request->status;
        

        if ($request->hasFile('banner')) {
            $row->addMediaFromRequest('banner')->withResponsiveImages()->toMediaCollection('banner');
        }


        // if($request->hasfile('banner')) 
        // {
        //     $file_response=FileManager::saveFile(
        //         $request->file('banner'),
        //         'storage/Photos',
        //         ['png','jpg','jpeg','gif']
        //     );
        //     if(isset($file_response['result']) && !$file_response['result'])
        //     {
                
        //         return back()->with('warning',$file_response['message']);
        //     }

        //     $old_file=$row->banner;
        //     FileManager::deleteFile($old_file);

        //     $row->banner = $file_response['filename'];
        // }

        $row->save();
        
        return redirect()->route('admin.photos.show',$id)
        ->with('success','Photo updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=Photo::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        // if($row['banner']!='')
        // {
        //     FileManager::deleteFile($row['banner']);
        // }
        
        $row->delete();
        
        return redirect()->route('admin.photos.index')
        ->with('success','Photo deleted successfully!');
    }
}