"use strict";
window.addEventListener('DOMContentLoaded', loadHandler2, false);
function loadHandler2() {
    Vue.component('display-love', {
        props: ['event', 'happenedAt', 'index'],
        template: '#display-love',
        computed: {
            countDown: function () {
                var nowMoment = moment();
                var beforeMoment = moment(this.happenedAt);
                var du = moment.duration(nowMoment - beforeMoment, 'ms');
                var year = du.get('year');
                var month = du.get('month'); // 0 to 11
                var day = du.get('day');
                var hours = du.get('hours');
                var minutes = du.get('minutes');
                var seconds = du.get('seconds');
                return year + " \u5E74 " + month + " \u6708 " + day + " \u5929 " + hours + " \u5C0F\u65F6 " + minutes + " \u5206\u949F " + seconds + " \u79D2";
            },
        },
    });
    var app = new Vue({
        data: {
            event: '',
            date: '',
            allEvents: [],
        },
        created: function () {
            var hash = location.hash.substr(1).match(/events=(.+)/) || [];
            if (!hash.length)
                return;
            var data = JSON.parse(decodeURIComponent(hash[1]));
            if (data && data.length) {
                var newData = [];
                for (var _i = 0, data_1 = data; _i < data_1.length; _i++) {
                    var item = data_1[_i];
                    var valid = moment(item.happenedAt).isValid();
                    if (valid)
                        newData.push(item);
                }
                newData.sort(function (a, b) { return moment(a.happenedAt) - moment(b.happenedAt); });
                this.allEvents = newData;
            }
        },
        methods: {
            add: function () {
                console.log(this.event, this.date);
                this.allEvents.push({
                    event: this.event,
                    happenedAt: this.date,
                });
                this.updateURLHash();
            },
            updateURLHash: function () {
                var json = JSON.stringify(this.allEvents);
                history.replaceState('', '', "#events=" + json);
            },
        },
    });
    app.$mount('#lost-love');
}
