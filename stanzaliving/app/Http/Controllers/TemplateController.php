<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Template;
use App\Templatekey;

class TemplateController extends Controller
{
	

	public function show($templatetype=''){

		//return $templatetype;

		if($templatetype=='sms'){
	
			$templates=Template::where('type','sms')->get();
			$templatetype='sms';
		return view('pages.admin.template.templatelist',compact('templates','templatetype'));

		}
		else if($templatetype=='email'){

			$templates=Template::where('type','email')->get();
			$templatetype='email';
		return view('pages.admin.template.templatelist',compact('templates','templatetype'));

		}
		
		
	}

	public function edit($key=''){

		$templatekeys=Templatekey::where('template_key',$key)->get();
		$templatedata=Template::where('template_key','send_email_after_parent_registration')->first();
		//return $templatedata;

		return view('pages.admin.template.templateedit',compact('templatekeys','templatedata','key'));
	}

	public function update(Request $request){

		//return $request->all();
		    
		     Template::where('template_key', $request->template_key)
        
                              ->update(

                                [
                               
                                'content'=>$request->mail_body,
                                
                                ]);

                \Session::flash('message','Template Sucessfully Updated.!');
                return \Redirect::back();
	}
    //
}
