<?php
$usuariosOnline = Painel::listarUsuariosOnline();
if (isset($_GET['loggout'])) {
    Painel::loggout();
}
?>
<!DOCTYPE html>
<html>


<head>
    <title>Painel de Controle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>estilo/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>css/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/stefangabos/Zebra_Datepicker/dist/css/default/zebra_datepicker.min.css">
    <link href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css" rel="stylesheet" />
    <link rel="icon" href="<?php echo INCLUDE_PATH; ?>favicon.ico" type="image/x-icon" />
    <script src='https://cdn.scaledrone.com/scaledrone.min.js'></script>
</head>

<body>
    <div class="box-content">
        <div class="welcome">
            <h2>Suporte | Chat de vídeo em tempo real</h2>
            <p>Não feche esta página! Ao abrir um chamado um chamado, é criado um ID único para controle do suporte. Mande o link, ou seja, sua URL completa para um Administrador e aguarde!</p>
            <p>Ou entre em contato enviado uma mensagem de texto <a href="<?php INCLUDE_PATH_PAINEL ?>chat">clicando aqui!</a></p>

        </div>

        <video id="localVideo" autoplay muted></video>
        <video id="remoteVideo" autoplay></video>


        <script>
            //Início ScaleDrone e WebRTC
            if (!location.hash) {
                location.hash = Math.floor(Math.random() * 0xFFFFFF).toString(16);
            }

            const roomHash = location.hash.substring(1);

            const drone = new ScaleDrone('PU5gd7vkJHiTm5nZ');

            const roomName = 'observable-' + roomHash;

            const configuration = {

                iceServers: [

                    {
                        urls: 'stun:stun.l.google.com:19302'
                    }

                ]

            }

            let room;
            let pc;

            let number = 0;


            function onSuccess() {};

            function onError(error) {
                console.log(error);
            };


            drone.on('open', error => {
                if (error)
                    return console.log(error);

                room = drone.subscribe(roomName);


                room.on('open', error => {
                    //Se acontecer erro, capturamos aqui!

                });

                room.on('members', members => {

                    //console.log("Conectado!");

                    //console.log("Conexões abertas: "+ members.length);
                    number = members.length - 1;
                    const isOfferer = members.length >= 2;

                    startWebRTC(isOfferer);

                })

            });

            function sendMessage(message) {
                drone.publish({
                    room: roomName,
                    message
                })
            }


            function startWebRTC(isOfferer) {


                pc = new RTCPeerConnection(configuration);

                pc.onicecandidate = event => {
                    if (event.candidate) {
                        sendMessage({
                            'candidate': event.candidate
                        });
                    }
                };


                if (isOfferer) {
                    pc.onnegotiationneeded = () => {
                        pc.createOffer().then(localDescCreated).catch(onError);
                    }
                }



                pc.ontrack = event => {
                    const stream = event.streams[0];


                    if (!remoteVideo.srcObject || remoteVideo.srcObject.id !== stream.id) {
                        remoteVideo.srcObject = stream;
                    }
                }


                navigator.mediaDevices.getUserMedia({
                    audio: true,
                    video: true,
                }).then(stream => {
                    localVideo.srcObject = stream;
                    stream.getTracks().forEach(track => pc.addTrack(track, stream))
                }, onError)

                room.on('member_leave', function(member) {
                    //Usuário saiu!
                    remoteVideo.style.display = "none";
                })

                room.on('data', (message, client) => {

                    if (client.id === drone.clientId) {
                        return;
                    }

                    if (message.sdp) {
                        pc.setRemoteDescription(new RTCSessionDescription(message.sdp), () => {
                            if (pc.remoteDescription.type === 'offer') {
                                pc.createAnswer().then(localDescCreated).catch(onErrror);
                            }
                        }, onError)
                    } else if (message.candidate) {
                        pc.addIceCandidate(
                            new RTCIceCandidate(message.candidate), onSuccess, onError
                        )
                    }

                })

            }

            function localDescCreated(desc) {
                pc.setLocalDescription(
                    desc, () => sendMessage({
                        'sdp': pc.localDescription
                    }), onError
                );
            }
        </script>
</body>

</html>