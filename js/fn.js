function photoCompress(file,w,objDiv){
    var ready=new FileReader();
    ready.readAsDataURL(file);
    ready.onload=function(){
        var re=this.result;
        canvasDataURL(re,w,objDiv)
    }
}
function canvasDataURL(path, obj, callback){
    var img = new Image();
    img.src = path;
    img.onload = function(){
        var that = this;
        // 默认按比例压缩
        var w = that.width,
            h = that.height,
            scale = w / h;
        w = obj.width || w;
        h = obj.height || (w / scale);
        console.log(obj);
        console.log(w);
        var quality = 0.7;
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var anw = document.createAttribute("width");
        anw.nodeValue = w;
        var anh = document.createAttribute("height");
        anh.nodeValue = h;
        canvas.setAttributeNode(anw);
        canvas.setAttributeNode(anh);
        ctx.fillStyle ="#fff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(that, 0, 0, w, h);
        var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        for(var i = 0; i < imageData.data.length; i += 4) {
            // 当该像素是透明的，则设置成白色
            if(imageData.data[i + 3] == 0) {
                imageData.data[i] = 255;
                imageData.data[i + 1] = 255;
                imageData.data[i + 2] = 255;
                imageData.data[i + 3] = 255;
            }
        }
        ctx.putImageData(imageData, 0, 0);
        if(obj.quality && obj.quality <= 1 && obj.quality > 0){
            quality = obj.quality;
        }
        var base64 = canvas.toDataURL('image/jpeg', 0.7);
        callback(base64);
    }
}
function convertBase64UrlToBlob(urlData){
    var arr = urlData.split(','), mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], {type:mime});
}
