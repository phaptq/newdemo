<!-- Auto get slug and seo tittle -->
<script >
  $(document).ready(function(){
        $('#title').on('keyup', function(e){
            var str = title.value;
            str= str.toLowerCase();
            str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
            str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
            str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
            str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
            str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
            str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
            str= str.replace(/đ/g,"d");
            str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
            /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
            str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
            str= str.replace(/^\-+|\-+$/g,"");
            //cắt bỏ ký tự - ở đầu và cuối chuỗi
            $('[name="slug"]').val(str);
            $('[name="seo[title]"]').val(title.value);
        });
    });
</script>
<!-- Js page loader -->
@if(isset($content))
<?php switch ($content) {
    case 'dashboard': ?>
        <!-- Google Maps API + Gmaps Plugin, must be loaded in the page you would like to use maps -->
        <script src="http://maps.google.com/maps/api/js"></script>
        <script src="{{asset('themes/admin/js/helpers/gmaps.min.js')}}"></script>

        <script src="{{asset('themes/admin/js/pages/index2.js')}}"></script>
        <script>$(function(){Index2.init();});</script>
        <?php break; ?>
    <?php case 'general_form': ?>
        <script src="{{asset('themes/admin/js/pages/formsGeneral.js')}}"></script>
        <script>$(function(){FormsGeneral.init();});</script>
        <?php break; ?>
<?php } ?>
<!-- Ckeditor -->
<script src="{{asset('themes/admin/js/helpers/ckeditor/ckeditor.js')}}"></script>
@endif