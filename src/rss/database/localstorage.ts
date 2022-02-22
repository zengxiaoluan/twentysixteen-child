import { isFeedAddress } from '../util'
import { FeedAddress } from '../interface'

const KEYLIST = 'rss-url'

export default class RSSStorage {
  static setFeedList(url: string) {
    if (!isFeedAddress(url)) return

    let list = localStorage.getItem(KEYLIST) || '[]'
    let arr: FeedAddress[] = JSON.parse(list)

    arr.push({ url, title: '', description: '' })

    localStorage.setItem(KEYLIST, JSON.stringify(arr))
  }
  static updateAllSubscribe(data: FeedAddress[]) {
    let str = JSON.stringify(data)
    localStorage.setItem(KEYLIST, str)
  }
  static getFeedList() {
    let str = localStorage.getItem(KEYLIST)
    let json = str ? JSON.parse(str) : []
    return json
  }
}
