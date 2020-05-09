<form action="{{$destroyUrl}}" method="POST" id="deleteItemFrm" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
@section('scripts')
    @parent
    <script>
        function deleteRec(){
            if(confirm('{{ trans('global.areYouSure') }}') ){
                document.getElementById('deleteItemFrm').submit();   
            }
            return false;
        }
    </script>
@endsection