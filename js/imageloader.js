/**
 * 削除系のメソッド
 * @param {*} input_id 
 * @param {*} preview_id 
 */
function delteImage(input_id,preview_id){
    document.getElementById(input_id).value = "";
    var preview = document.getElementById(preview_id);
    preview.innerHTML = "";
}
/**
 * 選択系のメソッド
 */
function selectImage(inputid,previewid){
    var frame = wp.media({
        title: "画像の選択",
        multiple: false, 
        library: {type: "image"} 
    });

    frame.on('select', function() {

        var image = frame.state().get('selection').first().toJSON(); 

        document.getElementById(inputid).value = image.id;

        var preview = document.getElementById(previewid);
        var previewImage = image.sizes.small || image;
        preview.innerHTML = '<img src="' + previewImage.url + '" style="width:80%; height:auto;"/>';
    });
    frame.open();
}