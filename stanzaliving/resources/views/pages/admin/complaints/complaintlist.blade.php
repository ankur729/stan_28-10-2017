@extends('layouts.master.admin.index')


@section('content')
<link rel="stylesheet" media="screen" type="text/css" href="css/datepicker.css" />
<script type="text/javascript" src="js/datepicker.js"></script>
         <div class="flash-message">
 @if(Session::has('message'))
    <div class="alert-box success" id="successMessage">
      <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
    </div>
@endif

@if(Session::has('duplicate'))
    <div class="alert-box danger" id="successMessage">
      <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('duplicate') }}</p>
    </div>
@endif
  </div>
   <!-- Main content -->
    <section class="content">

       <!-- SEARCH FORM -->
{!! Form::open(['url' => 'admin/complaint/search','method' => 'post']) !!}
               <div class="form" >
         
          {{ csrf_field() }}
                 <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label>Date</label><br>


    {!!     Form::text('date', null,  ['class' => 'form-control', 'placeholder' => 'yy-mm-dd','id'=>'p_dob']) !!}

         
                   </div>
                 </div>
         
           <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label>Status</label><br>


              
              <select class="form-control" name="status">
                  
                  <option value="">--Select Status--</option>
                  <option value="0">Low</option>
                  <option value="1">Medium</option>
                  <option value="2">High</option>
                
              </select>

         
                   </div>
                 </div>

                      <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label>Category</label><br>

            <select class="form-control" name="category" id="categoryid">
                   <option value="">--Select Category --</option>
                @foreach($compcat as $cat)
                  <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
                
              </select>

         
                   </div>
                 </div>

                      <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label>Sub Category</label><br>

              <select class="form-control" name="subcategory" id="subcategoryid">
              
              </select>

         
                   </div>
                 </div>
         
      
         
         <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-danger" style="width: 225px;">
    <i class="fa fa-search "></i> Search
</button>
      
          
                    
                   </div>
                 </div>

         
         
         
        
         
         
               </div>

                {!! Form::close() !!}


                <!-- SEARCH FORM -->

     <div class="row">
        <div class="col-xs-12 ">
           <div class="box">
             <div class="box-header">
               <div class="form">
                 <div class="col-xs-3">
                  <div class="form-group">
                    <label></label><Br>

                   All Complaints
                   </div>
                 </div>
               </div>
             </div>
           </div>
        </div>
     </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
         
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>

                  
                <tr>
                  <th>S. No.</th>
                  <th>Date of Opening | Duration</th>
                  <th>Category</th>
                  <th>Sub Category</th>
                  <th>Urgency</th>
                  <th>Status</th>
                  <th>Options</th>
                </tr>


                </thead>
                <tbody>
            @foreach($complaints as $key=>$complaint)
                  <tr>
                    <td>{{$key+1}}</td>
                      <td>{{ Carbon\Carbon::parse($complaint->created_at)->format('d-m-Y')}} 
                      &nbsp;&nbsp;
                        |
                        &nbsp;&nbsp;
                     {{ Carbon\Carbon::parse($complaint->created_at)->diffForHumans()}}
                     </td>
                  
                    <td>{{$mycat[$complaint->c_category]}}</td>
                    <td>{{$mysubcat[$complaint->c_subcategory]}}</td>
                    @if($complaint->c_urgency==0)
                    <td>Low</td>
                   @elseif($complaint->c_urgency==1)
                    <td>Medium</td>
                    @elseif($complaint->c_urgency==2)
                    <td>High</td>
              

                    @endif
                    <td>{{$complaint->c_status}}</td>
                    <td>  <a title="View/Edit"  href="{{action('ComplaintController@show',['id'=>$complaint->id])}}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;/&nbsp;<i class="fa fa-edit" aria-hidden="true"></i></a>
          
           </td>
                  </tr>
                  @endforeach
                        </tbody>
             <!--    <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot> -->
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<!-- Modal -->

</div>

    </section>
    <!-- /.content -->

@endsection

@push('scripts')
<script> 


$(document).ready(function(){
        setTimeout(function() {
          $('#successMessage').fadeOut('slow');
         // $('#errorMessage').fadeOut('slow');
        }, 4000); // <-- time in milliseconds

         $("#p_dob").datepicker({
     
      dateFormat: "yy-mm-dd",
       yearRange: '1980:2017',
      numberOfMonths: 1,
      changeMonth: true,
        changeYear: true
    });
$('#p_dob').change(function(){
  if(! $(this).val().match('^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$') )
  {
    alert('Invalid Date Format');
    $(this).val(' ');
    $(this).focus();
  }
});


    });


$('#categoryid').change(function(){

    var s_id=$(this).val();

  $.ajax({
    type:'GET',
    url:'subcategories',
    data:{s_id:s_id},
     
    beforeSend:function(){
 
    },
    success:function(data){
  
  
    $('#subcategoryid').html(data);


    }
});
});



</script>


@endpush