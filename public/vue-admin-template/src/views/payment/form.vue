<template>
  <el-dialog title="" :visible.sync="show" :close-on-click-modal="false" @close="closeDialog">
    <el-form :model="form" label-position="top">
      <el-form-item label="支付方式名称">
        <el-input v-model="form.name" placeholder="请输入支付方式名称" />
      </el-form-item>

      <el-form-item label="支付商">
        <el-select v-model="form.providerId" placeholder="请选择支付商" clearable>
          <el-option v-for="item in paymentProviders" :key="item.id" :value="item.id" :label="item.name" />
        </el-select>
      </el-form-item>

      <el-form-item label="支付类型">
        <el-select v-model="form.paymentType" placeholder="请选择支付类型" clearable>
          <el-option v-for="item in paymentTypes" :key="item.id" :value="item.id" :label="item.name" />
        </el-select>
      </el-form-item>

      <el-form-item label="状态">
        <el-select v-model="form.status" placeholder="请选址状态" clearable>
          <el-option :value="1" label="正常" />
          <el-option :value="0" label="禁用" />
        </el-select>
      </el-form-item>

      <el-form-item label="备注">
        <el-input v-model="form.remark" type="textarea" placeholder="请输入备注" />
      </el-form-item>

      <el-form-item label="">
        <el-button type="success" @click="submit">提 交</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import { createPayment, showPayment, updatePayment } from '@/api/payment'
import dialogMixin from '@/mixins/dialogMixin'

export default {
  mixins: [dialogMixin],
  props: {
    targetId: {
      type: Number,
      default: 0
    },
    paymentProviders: {
      type: Array,
      default: () => []
    },
    paymentTypes: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      form: {}
    }
  },
  mounted() {
    if (this.targetId !== 0) {
      showPayment(this.targetId).then(res => {
        this.$set(this.form, 'name', res.data.name)
        this.$set(this.form, 'providerId', res.data.provider_id)
        this.$set(this.form, 'paymentType', res.data.type)
        this.$set(this.form, 'status', res.data.status)
        this.$set(this.form, 'remark', res.data.remark)
      })
    }
  },
  methods: {
    async submit() {
      this.targetId === 0 ? await createPayment(this.form) : await updatePayment(this.targetId, this.form)
      this.$message.success('提交成功')
      this.$emit('submitSuccess')
      this.show = false
    }
  }
}
</script>
