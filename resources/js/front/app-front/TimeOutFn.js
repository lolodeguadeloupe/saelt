const Lancheur = (function () {
    var _lancher = function (callback, timing = 12000) {
        this.interval = setInterval(() => {
            if (this.task == 0 && typeof callback == 'function') {
                this.task = 1;
                callback(this);
            }
        }, timing);
    }
    var _delete = function(){
        if(this.interval != null){
            clearInterval(this.interval);
        }
    }

    const myInstance = function () {
        this.task = 0;
        this.interval = null;
        this.lancher = _lancher.bind(this);
        this.clear = _delete.bind(this);
        return this;
    }

    return function () {
        return myInstance.apply(this);
    }
})()

export default Lancheur;



