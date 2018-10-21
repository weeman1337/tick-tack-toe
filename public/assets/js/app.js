
var log = function (msg) {
    $('#error').html('<div class="alert alert-danger" role="alert">' + msg + '</div>');
};

var conn = new WebSocket('ws://192.168.178.37:1337');
conn.onopen = function (e) {
    console.log("Connection established!");
};

conn.onmessage = function (e) {
    console.log(e.data);
};

conn.onerror = function (e) {
    log('Fehler ist aufgetretten.');
    console.log(e);
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
                roomId: room
            })
    );
});

$('#tictac tr td').on('click', function() {
    var self = $(this);

    if (self.hasClass('checked-x')) {

        log('du hast schonmal x geklickt');

    } else {
        conn.send(
            JSON.stringify(
                {
                    method:'check',
                    roomId: room,
                    fieldNumber: self.data('id')
                }
            )
        );
        self.addClass('checked-x');
        self.html('X');
    }

});