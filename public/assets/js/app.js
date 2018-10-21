
var conn = new WebSocket('ws://192.168.178.37:1337');
conn.onopen = function (e) {
    console.log("Connection established!");
};

conn.onmessage = function (e) {
    console.log(e.data);
};

let urlParams = new URLSearchParams(window.location.search);
let room = urlParams.get('game');

$(window).on('load', function(){
    $('#title').html('Room ' + room);

});

$('#join').on('click', function(){
    conn.send(
        JSON.stringify(
            {
                roomId:room
            })
    );
});

$('#tictac tr td').on('click', function() {
    conn.send(
        JSON.stringify({method:'ich will rein'})
        );
    $(this).html('X');
});