interface LoveEvent {
  event: string
  happenedAt: string
  loaded: number
}

declare var Vue: any
declare var moment: any

window.addEventListener('DOMContentLoaded', loadHandler2, false)

function loadHandler2() {
  Vue.component('display-love', {
    props: ['event', 'happenedAt', 'index'],
    template: '#display-love',
    computed: {
      countDown() {
        let nowMoment = moment()
        let beforeMoment: number = moment(this.happenedAt)

        let du = moment.duration(nowMoment - beforeMoment, 'ms')
        let year = du.get('year')
        let month = du.get('month') // 0 to 11
        let day = du.get('day')
        let hours = du.get('hours')
        let minutes = du.get('minutes')
        let seconds = du.get('seconds')

        return `${year} 年 ${month} 月 ${day} 天 ${hours} 小时 ${minutes} 分钟 ${seconds} 秒`
      },
    },
  })

  let app = new Vue({
    data: {
      event: '',
      date: '',
      allEvents: [] as LoveEvent[],
    },

    created() {
      let hash = location.hash.substr(1).match(/events=(.+)/) || []
      let data = JSON.parse(decodeURIComponent(hash[1])) as LoveEvent[]

      if (data && data.length) {
        let newData = []
        for (const item of data) {
          let valid = moment(item.happenedAt).isValid()
          if (valid) newData.push(item)
        }
        newData.sort((a, b) => moment(a.happenedAt) - moment(b.happenedAt))
        this.allEvents = newData
      }
    },

    methods: {
      add() {
        console.log(this.event, this.date)

        this.allEvents.push({
          event: this.event,
          happenedAt: this.date,
        })

        this.updateURLHash()
      },
      updateURLHash() {
        let json = JSON.stringify(this.allEvents)
        history.replaceState('', '', `#events=${json}`)
      },
    },
  })

  app.$mount('#lost-love')
}
