import dayjs from '@/plugins/day'
import {DATE_FORMAT, DATETIME_DB_FORMAT, DATETIME_FORMAT} from '@/base/constants/time.constants'

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
        return dayjs(datetime).isValid() ? dayjs(datetime, DATETIME_DB_FORMAT).format(DATE_FORMAT) : ''
    },
    time: function (datetime) {
        return dayjs(datetime).isValid() ? dayjs(datetime, DATETIME_DB_FORMAT).format(DATETIME_FORMAT) : ''
    },
}
