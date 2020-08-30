import { isFeedAddress } from '../util'

const KEYLIST = 'rss-url'

export default class RSSStorage {
  static setFeedList(feed: string) {
    if (!isFeedAddress(feed)) return

    let list = localStorage.getItem(KEYLIST) || '[]'
    let arr: string[] = JSON.parse(list)

    arr.push(feed)

    localStorage.setItem(KEYLIST, JSON.stringify(arr))
  }
  static getFeedList() {
    let str = localStorage.getItem(KEYLIST) || ''
    let json = JSON.parse(str) || []
    return json
  }
}
