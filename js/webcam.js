var streaming = false,
    video        = document.getElementById('video'),
    imageloader  = document.getElementById('imageloader'),
    imageshow    = document.getElementById('imageshow'),
    canvas       = document.getElementById('canvas'),
    startbutton  = document.getElementById('startbutton'),
    selectelem   = document.getElementById('photo-filter'),
    filterimg    = document.getElementById('filterimg'),
    webcamdiv    = document.getElementById('webcam-filter'),
    submitf      = document.getElementById('submitf'),
    picurl       = document.getElementById('picurl'),
    customfile   = document.getElementById('customfile'),
    strike       = document.getElementById('strike');
    allowedext   = /(\.jpg|\.png)$/i,
    width = 720,
    height = 530;

navigator.getMedia = ( navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function(stream) {
        video.srcObject = stream;
        video.play();
        imageloader.addEventListener('change', handleImage, false);
    })
    .catch(function() {
        video.parentNode.removeChild(video);
        strike.parentNode.removeChild(strike);
        imageloader.addEventListener('change', handleImage, false);
        selectelem.disabled = imageloader.files.length === 0;
    });

video.addEventListener('canplay', function(ev){
    if (!streaming) {
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        streaming = true;
    }
}, false);

function takepicturevideo() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    const data = canvas.toDataURL('image/png');
    picurl.value = data;
    submitf.submit();
}

function takepictureimage() {
    submitf.submit();
}

function handleImage(e){
    if (imageloader.files[0].size > 5242880) {
        alert("File is too big!");
        imageloader.value = "";
    } else {
        if (imageloader.files.length !== 0) {
            selectelem.disabled = false;
        }
        if(!allowedext.exec(imageloader.value)){
            alert('Please upload file having extensions .jpg .png only.');
            imageloader.value = '';
            return false;
        } else {
            if (video.parentNode != null) {
                video.parentNode.removeChild(video);
            }
            customfile.parentNode.removeChild(customfile);
            if (strike.parentNode != null) {
                strike.parentNode.removeChild(strike);
            }
            var reader = new FileReader();
            reader.onload = function (event) {
                var img = new Image();
                img.onload = function () {
                    canvas.width = width;
                    canvas.height = height;
                    canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                    var data = canvas.toDataURL('image/png');
                    val = picurl.value = data;
                    imageshow.setAttribute('src', val);
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    }
}

function enableButton() {
    var value = selectelem.value;

    webcamdiv.addEventListener("click", function(event) {
        var xPosition = event.clientX - webcamdiv.getBoundingClientRect().left - (filterimg.clientWidth);
        var yPosition = event.clientY - webcamdiv.getBoundingClientRect().top - (filterimg.clientHeight);
        filterimg.style.left = xPosition + "px";
            filterimg.style.top = yPosition + "px";
            document.getElementById('emox').value = xPosition;
            document.getElementById('emoy').value = yPosition;
        }
    );

    if (value === "none") {
        startbutton.disabled = true;
        filterimg.hidden = true;
        filterimg.setAttribute ('src', '');
        filterimg.setAttribute('style', '');
    } else if (value === "banana") {
        startbutton.disabled = false;
        filterimg.hidden = false;
        filterimg.setAttribute('src', 'filters/banana.png');
        filterimg.setAttribute('style', 'position: absolute; top: 0; left: 0; width: 150px;height: 150px;');
    } else if (value === "emo1") {
        startbutton.disabled = false;
        filterimg.hidden = false;
        filterimg.setAttribute('src', 'filters/emo1.png');
        filterimg.setAttribute('style', 'position: absolute; top: 0; left: 0; width: 150px;height: 150px;');
    } else if (value === "emo2") {
        startbutton.disabled = false;
        filterimg.hidden = false;
        filterimg.setAttribute('src', 'filters/emo2.png');
        filterimg.setAttribute('style', 'position: absolute; top: 0; left: 0; width: 150px;height: 150px;');
    } else if (value === "emo3") {
        startbutton.disabled = false;
        filterimg.hidden = false;
        filterimg.setAttribute('src', 'filters/emo3.png');
        filterimg.setAttribute('style', 'position: absolute; top: 0; left: 0; width: 150px;height: 150px;');
    } else if (value === "twitter") {
        startbutton.disabled = false;
        filterimg.hidden = false;
        filterimg.setAttribute('src', 'filters/twitter.png');
        filterimg.setAttribute('style', 'position: absolute; top: 0; left: 0; width: 150px;height: 150px;');
    } else if (value === "whatsapp") {
        startbutton.disabled = false;
        filterimg.hidden = false;
        filterimg.setAttribute('src', 'filters/whatsapp.png');
        filterimg.setAttribute('style', 'position: absolute; top: 0; left: 0; width: 150px;height: 150px;');
    }
}

function takepicture() {
    if (video.parentNode != null && imageloader.files.length === 0) {
        takepicturevideo();
    } else {
        takepictureimage();
    }
}