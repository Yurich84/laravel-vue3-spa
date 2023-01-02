import {ref} from 'vue'

export function useErrors() {
    const errors = ref({})

    function clear(field = null) {
        if (field) {
            if (has(field)) {
                delete errors.value[field]
            }

            return
        }

        errors.value = {}
    }

    function has(field) {
        return errors.value.hasOwnProperty(field)
    }

    function get(field) {
        if (errors.value[field]) {
            return errors.value[field][0]
        }

        return ''
    }

    function record(errs) {
        errors.value = errs
    }

    return {
        errors,
        clear,
        has,
        get,
        record
    }
}
