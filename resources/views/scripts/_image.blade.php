<?php
$extentions = (array_key_exists("extentions", $input->getOptions())) ? $input->getOptions()['extentions']
        : [];
?>
@push('scripts')
<script>
    $("#{{$name}}Thumbnail").click(function(){
        $("#{{$name}}").click();
    });
    $("#{{$name}}").on("change", function (ev) {
        console.log(ev);
<?php
if (sizeof($extentions) > 0) {
    $validaateExtentions = [];
    foreach ($extentions AS $ext) {
        $validaateExtentions[] = '"'.strtoupper($ext).'"';
        $validaateExtentions[] = '"'.strtolower($ext).'"';
    }
    ?>
            var validExt = [<?= implode(", ", $validaateExtentions) ?>];
            var ext = $("#{{$name}}").val().replace(/^.*\./, '');
            if (validExt.indexOf(ext) < 0) {
                $("#{{$name}}").val("");
                $("#{{$name}}Thumbnail").attr("src", "{{ asset('images/dummy_image.png') }}");
                swal("Invalid Extentions!", "Available extentions are {{ implode(', ', $extentions) }}", "warning")
                return false;
            }

    <?php
}
?>
        var f = ev.target.files[0];
        var fr = new FileReader();
        fr.onload = function (ev2) {
            var fileurl = ev2.target.result;
            $("#{{$name}}Thumbnail").attr("src", fileurl);
        }
        fr.readAsDataURL(f);
    });
</script>
@endpush