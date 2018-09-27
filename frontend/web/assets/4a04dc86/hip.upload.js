
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
        xhr: XMLHttpRequest,
        
        stop: function() {
            if ( this.xhr !== null && this.xhr instanceof XMLHttpRequest) {
                this.xhr.abort();
                this.error = "stop: by manual";
                this.is_stop = 1;
            }
        },

        start: function(file) {
            // Skip validation if File API is not available
            if (typeof File === "undefined" || !(file instanceof File)) {
                this.error = "send: File undefined or input is not file type";
                return;
            }

            this.start = 0;
            this.end = this.start + LENGTH;
            this.blob_now = 0;
            this.total_blob_num = Math.ceil(file.size / LENGTH);
            this.is_stop = 0;
            this.xhr = new XMLHttpRequest();
        },

        cut: function(file) {
            var file_blob = file.slice(this.start, this.end);
            this.start = this.end;
            this.end = this.start + LENGTH;
            this.blob_now += 1;
            return file_blob;
        },

        send: function(file, url, progress) {
            var form_data = new FormData();
            var file_blob = this.cut(file);

            form_data.append('file', file_blob);
            form_data.append('fb_name', file.name);
            form_data.append('blobNow', this.blob_now);
            form_data.append('totalBlobNum', this.total_blob_num);

            xhr.open('POST', url, false);
            this.xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // show progress
                    progress(progress);

                    // send the left
                    if (this.blob_now < this.total_blob_num && this.is_stop === 0) {
                        send(file, url, progress);
                    } else {
                    }
                }
            }
            this.xhr.send(form_data);
        },
    };

    function progress(progress) {
        if (progress !== null) {
            progress.style.width = Math.min(100, (blob_now/total_blob_num) * 100) + '%';
        }
    };

    return pub;
})(window.jQuery);
