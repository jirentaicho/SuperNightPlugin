var btns = document.querySelectorAll('.save-button');
btns.forEach(btn => {
    btn.addEventListener('click',() => {
        // btnの階層からパラメータを取得する
        const data = btn.previousElementSibling;
        saveData(data);
    });
})

/**
 * スケジュール情報を保存します。
 */
function saveData(data){

    var fade = document.getElementById('super-night-loading');
    fade.classList.remove("super-night-close");

    const inputs = data.getElementsByTagName('input');
    let param = new URLSearchParams();
    // スプレッド演算子を使ってループを回します。
    [ ... inputs].forEach(input => param.append(input.name,input.value) )
    param.append("action", 'register_ajax_data')
    param.append("nonce", ex_values.nonce)
    param.append("unko","chinko");

    fetch(ex_values.admin_url,{
        method : 'POST',
        credentials: "same-origin",
        body : param
    })
    .then(res => res.json())
    .then(data => {
        if(data[0].hasOwnProperty('error')){
            alert(data[0].error);
        }
    })
    .catch(e => {
        alert("エラーが発生しました。");
    })
    .finally(() => {
        fade.classList.add('super-night-close');
    })
}

/**
 * Ajaxに必要なパラメータの作成を行います。
 * add : パラメータを追加します。
 * build : URLSearchParamsを返却します。
 */
function AjaxCriteria(){
    const param = new URLSearchParams();
    return {
        add(key,value){
            param.append(key,value)
            return this;
        },
        build(){
            return param;
        }
    };
}
