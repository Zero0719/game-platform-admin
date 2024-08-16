<template>
  <div class="app-container">
    1
  </div>
</template>

<script>
import pageMixin from '@/mixins/pageMixin'
import { getPayPlatform, getPayType } from '@/api/payment'

export default {
  name: 'Payments',
  mixins: [pageMixin],
  data() {
    return {}
  },
  mounted() {
    getPayPlatform().then(res => {
      console.log(res)
    })

    getPayType().then(res => {
      console.log(res)
    })
  }
}
</script>
