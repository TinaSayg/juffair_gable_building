{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')

    <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <h4>Notice Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Notice</label>
                                <input type="text" name="notice_text" value="{{ isset($noticeboard->notice_text) ? $noticeboard-> : 'notice_text' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Date</label>
                                <input type="text" name="notice_date" value="{{ isset($noticeboard->notice_date) ? $noticeboard->notice_date : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Status</label>
                                <input type="text" name="notice_board_status_code" value="{{ isset($noticeboard->notice_boardstatus_code) ? $noticeboard->notice_boardstatus_code : '' }}" class="form-control">
                            </div>
                           
                    </div>
                    <a href="{{ route('notice.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>




@stop
@section('footer_scripts')
<script>
  
</script>
@stop