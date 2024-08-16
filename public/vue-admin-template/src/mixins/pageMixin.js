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
    // 搜索
    search() {
      this.searchForm.page = 1
      this.fetchData()
    },

    // 跳页
    changePage(page) {
      this.searchForm.page = page
      this.fetchData()
    },

    // 清除搜索框表单
    clearSearchForm() {
      this.searchForm = {
        page: 1,
        pageSize: 15
      }
    },

    // 获取列表数据
    async fetchData() {
      if (typeof this.pageUrl !== 'function') {
        return
      }
      this.loading = true
      const result = await this.pageUrl(this.searchForm)
      this.pageData = result.data
      this.loading = false
    },

    // 关闭弹窗
    closeDialog() {
      this.targetId = 0
      this.pageComponent = null
    }
  }
}
