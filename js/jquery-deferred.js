$.deferred.when($.post('/song', { id: 1 }), $.post('/song', { id: 2 }, $.post('/song', { id: 3 }).then(drawToDOM);

function drawToDOM(song1, song2, song3) {
    /* draw :) */
}
