export default {
  data() {
    return {
      show: true
    }
  },
  methods: {
    closeDialog() {
      this.$emit('closeDialog')
      this.$destroy()
    }
  }
}
