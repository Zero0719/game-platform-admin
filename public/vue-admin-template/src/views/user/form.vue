<template>
  <el-dialog title="" :visible.sync="show" :close-on-click-modal="false" @close="closeDialog">
    <el-form :model="submitForm" auto-complete="off">
      <el-form-item label="用户名">
        <el-input v-model="submitForm.username" placeholder="" />
      </el-form-item>

      <el-form-item label="密码">
        <el-input v-model="submitForm.password" type="password" placeholder="" />
      </el-form-item>

      <el-form-item label="">
        <el-button type="" @click="clearForm">清 除</el-button>
        <el-button type="success" @click="submit">提 交</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import dialogMixin from '@/mixins/dialogMixin'
import { createUser, showUser, updateUser } from '@/api/user'

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
      show: true,
      submitForm: {
      }
    }
  },
  mounted() {
    if (this.targetId !== 0) {
      showUser(this.targetId).then(res => {
        this.$set(this.submitForm, 'username', res.data.username)
      })
    }
  },
  methods: {
    async submit() {
      this.targetId === 0 ? await createUser(this.submitForm) : await updateUser(this.targetId, this.submitForm)
      this.$emit('submitSuccess')
      this.$message.success('提交成功')
      this.show = false
    },
    clearForm() {
      this.submitForm = {}
    }
  }
}
</script>
