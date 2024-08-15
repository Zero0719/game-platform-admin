<template>
  <el-dialog title="" :visible.sync="show" @close="closeDialog">
    <el-descriptions title="日志详情" :column="1" border>
      <el-descriptions-item label="日志ID">{{ detail.id }}</el-descriptions-item>
      <el-descriptions-item label="用户ID">{{ detail.user_id }}</el-descriptions-item>
      <el-descriptions-item label="请求接口">{{ detail.url }}</el-descriptions-item>
      <el-descriptions-item label="请求IP">{{ detail.ip }}</el-descriptions-item>
      <el-descriptions-item label="携带参数">{{ detail.data }}</el-descriptions-item>
      <el-descriptions-item label="时间">{{ detail.created_at }}</el-descriptions-item>
    </el-descriptions>
  </el-dialog>
</template>

<script>
import dialogMixin from '@/mixins/dialogMixin'
import { showLog } from '@/api/log'

export default {
  mixins: [dialogMixin],
  props: {
    targetId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      detail: {}
    }
  },
  mounted() {
    if (this.targetId !== 0) {
      this.getDetail(this.targetId)
    }
  },
  methods: {
    async getDetail(id) {
      const res = await showLog(id)
      this.detail = res.data
    }
  }
}
</script>
