
const LENGTH = 1024 * 1024;
var hip = new Object();

hip.upload = (function ($) {
    var pub = {   

        error: String,
        total_blob_num: Number,
        is_stop: Number,
        blob_now: Number,
        end: Number,
        start: Number,
        xhr: Object,


        progress: function(progress) {
            if (progress !== null) {
                progress.style.width = Math.min(100, (blob_now/total_blob_num) * 100) + '%';
            }
        },
        
        stop: function() {
            if ( xhr !== null && xhr instanceof XMLHttpRequest) {
                xhr.abort();
                error = "stop: by manual";
                is_stop = 1;
            }
        },

        start: function(file) {
            // Skip validation if File API is not available
            if (typeof File === "undefined" || !(file instanceof File)) {
                error = "send: File undefined or input is not file type";
                return;
            }

            start = 0;
            end = start + LENGTH;
            blob_now = 0;
            total_blob_num = Math.ceil(file.size / LENGTH);
            is_stop = 0;
            xhr = new XMLHttpRequest();
        },

        cut: function (file) {
            var file_blob = file.slice(start, end);
            start = end;
            end = start + LENGTH;
            blob_now += 1;
            return file_blob;
        },

        send: function(file, url, progress) {
            var form_data = new FormData();
            var file_blob = this->cut(file);

            form_data.append('file', file_blob);
            form_data.append('fb_name', file.name);
            form_data.append('blobNow', blob_now);
            form_data.append('totalBlobNum', total_blob_num);

            xhr.open('POST', url, false);
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // show progress
                    progress(progress);

                    // send the left
                    if (blob_now < total_blob_num && is_stop === 0) {
                        send(file);
                    } else {
                    }
                }
            }
            xhr.send(form_data);
        },
    };

    return pub;
})(window.jQuery);
