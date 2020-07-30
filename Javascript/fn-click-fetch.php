<?php
$fetch_init_objectd = [
    'method' => 'post',
    'body' => ['action'=>'myaction', 'id'=>$id],
];
?>

<button
    class="fn-click-fetch"
    data-fetch-url="path/to/file"
    data-fetch-init="<?= htmlspecialchars(json_encode($fetch_init_object), ENT_QUOTES, 'UTF-8') ?>"
    data-fetch-callback-name="myCallback"
>
    Action
</button>

<script>
document.addEventListener('DOMContentLoaded', function(e){
    var els = document.querySelectorAll('.fn-click-fetch'); // Possible TODO: https://stackoverflow.com/questions/9106329/implementing-jquerys-live-binder-with-native-javascript
    els.forEach(function(el){
        el.addEventListener('click', function(e){
            var target = e.target;
            if (e.target.disabled) return;
            let type = 'FormData';
            let init = JSON.parse(el.dataset.fetchInit || '{}');
            let url = el.dataset.fetchUrl || window.location.href;
            init.method = init.method || el.dataset.fetchMethod || 'get';
            let cb = el.dataset.fetchCallbackName || '';
            if (type == 'FormData' && init.body) {
                let formData = new FormData();
                for (let i in init.body) {
                    formData.append(i, init.body[i]);
                }
                let urlSearchParams = new URLSearchParams(formData);
                init.body = formData;
            } /* else if ( type == 'json' ) { // TODO: Erweitern
                //urlSearchParams;//.toString();
                init.body = JSON.stringify(init.body);
            } */
            console.log(init);
            fetch(url, init).then(function(response) { if ( cb.length ) window[cb](response, target); });
        })
    });
});
</script>

<script>
function myCallback(response, target) {
    response.json().then(function(json){ console.log(json); })
}
</script>
