<template>
  <el-dialog title="" :visible.sync="show" :close-on-click-modal="false" @close="closeDialog">
    <el-form :model="form" label-position="top">
      <el-form-item label="支付商">
        <el-input v-model="form.name" placeholder="请输入支付商" />
      </el-form-item>

      <el-form-item label="app_id">
        <el-input v-model="form.appId" placeholder="请输入应用app_id" />
      </el-form-item>

      <el-form-item label="app_secret">
        <el-input v-model="form.appSecret" type="textarea" rows="3" placeholder="请输入应用密钥" />
      </el-form-item>

      <el-form-item label="状态">
        <el-select v-model="form.status" placeholder="请选择状态" clearable>
          <el-option :value="0" label="停用" />
          <el-option :value="1" label="正常" />
        </el-select>
      </el-form-item>

      <el-form-item label="接入状态">
        <el-select v-model="form.isAccess" placeholder="请选择接入状态" clearable>
          <el-option :value="0" label="未接入" />
          <el-option :value="1" label="已接入" />
        </el-select>
      </el-form-item>

      <el-form-item label="回调地址">
        <el-input v-model="form.notifyUrl" placeholder="请输入回调地址" />
      </el-form-item>

      <el-form-item label="备注">
        <el-input v-model="form.remark" type="textarea" rows="3" placeholder="请输入备注" />
      </el-form-item>

      <el-form-item label="">
        <el-button type="success" @click="submit">提 交</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import dialogMixin from '@/mixins/dialogMixin'
import { createPaymentProvider, showPaymentProvider, updatePaymentProvider } from '@/api/payment_provider'

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
      showPaymentProvider(this.targetId).then(res => {
        this.$set(this.form, 'name', res.data.name)
        this.$set(this.form, 'appId', res.data.app_id)
        this.$set(this.form, 'appSecret', res.data.app_secret)
        this.$set(this.form, 'status', res.data.status)
        this.$set(this.form, 'isAccess', res.data.is_access)
        this.$set(this.form, 'notifyUrl', res.data.notify_url)
        this.$set(this.form, 'remark', res.data.remark)
      })
    }
  },
  methods: {
    async submit() {
      this.targetId === 0 ? await createPaymentProvider(this.form) : await updatePaymentProvider(this.targetId, this.form)
      this.$message.success('提交成功')
      this.$emit('submitSuccess')
      this.show = false
    }
  }
}
</script>
