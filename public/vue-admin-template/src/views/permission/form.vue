<template>
  <el-dialog title="" :visible.sync="show" :close-on-click-modal="false" @close="closeDialog">
    <el-form :model="form">
      <el-form-item label="权限名">
        <el-input v-model="form.name" placeholder="" />
      </el-form-item>

      <el-form-item label="权限标识">
        <el-input v-model="form.flag" placeholder="" />
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
import { createPermission, updatePermission, showPermission } from '@/api/permission'

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
      showPermission(this.targetId).then(res => {
        this.$set(this.form, 'name', res.data.name)
        this.$set(this.form, 'flag', res.data.flag)
      })
    }
  },
  methods: {
    async submit() {
      this.targetId === 0 ? await createPermission(this.form) : await updatePermission(this.targetId, this.form)
      this.$message.success('提交成功')
      this.$emit('submitSuccess')
      this.show = false
    }
  }
}
</script>
