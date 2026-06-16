import dayjs from '@/plugins/day'
import {DATE_FORMAT, DATETIME_FORMAT} from '@/base/constants/time.constants'

export default {
    capitalize: function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
    },
    price: function (number) {
        return Number(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '\'')
    },
    date: function (datetime) {
        const d = dayjs(datetime)
        return d.isValid() ? d.format(DATE_FORMAT) : ''
    },
    time: function (datetime) {
        const d = dayjs(datetime)
        return d.isValid() ? d.format(DATETIME_FORMAT) : ''
    },
}
