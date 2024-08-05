export default {
  data() {
    return {
      searchForm: {
        page: 1,
        pageSize: 15
      },
      pageData: {
        lists: [],
        count: 0
      },
      loading: false,
      pageUrl: null, // 定义页面列表请求的接口 this.pageUrl = userList
      pageComponent: null, // 页面中有dialog需要打开时，可以用 <component :is="pageComponent"> 的方式打开
      targetId: 0 // 编辑时，定义该目标id，
    }
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    search() {
      this.searchForm.page = 1
      this.fetchData()
    },
    changePage(page) {
      this.searchForm.page = page
      this.fetchData()
    },
    clearSearchForm() {
      this.searchForm = {
        page: 1,
        pageSize: 15
      }
    },
    async fetchData() {
      if (typeof this.pageUrl !== 'function') {
        throw new Error('请给 pageUrl 赋值请求函数')
      }
      this.loading = true
      const result = await this.pageUrl(this.searchForm)
      this.pageData = result.data
      this.loading = false
    },
    closeDialog() {
      this.targetId = 0
      this.pageComponent = null
    }
  }
}
