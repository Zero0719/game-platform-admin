<template>
  <el-dialog title="" :visible.sync="show" @close="closeDialog">
    <el-form :model="form">
      <el-form-item label="游戏名">
        <el-input v-model="form.name" placeholder="请输入游戏名" />
      </el-form-item>

      <el-form-item label="">
        <el-button type="" @click="form = {}">清 除</el-button>
        <el-button type="success" @click="submit">提 交</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import dialogMixin from '@/mixins/dialogMixin'
import { createGame, updateGame, showGame } from '@/api/game'

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
      form: {}
    }
  },
  mounted() {
    if (this.targetId !== 0) {
      this.showGame(this.targetId)
    }
  },
  methods: {
    async showGame(id) {
      const res = await showGame(id)
      this.$set(this.form, 'name', res.data.name)
    },
    async submit() {
      this.targetId === 0 ? await createGame(this.form) : await updateGame(this.targetId, this.form)

      this.$message.success('提交成功')
      this.$emit('submitSuccess')
      this.show = false
    }
  }
}
</script>
