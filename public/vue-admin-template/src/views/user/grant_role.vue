<template>
  <el-dialog title="" :visible.sync="show" :close-on-click-modal="false" @close="closeDialog">
    <el-transfer v-model="roles" :data="allRoles" :titles="['所有角色', '已有角色']" filterable />
    <el-button type="success" style="margin-top: 10px;" @click="submit">提 交</el-button>
  </el-dialog>
</template>

<script>
import dialogMixin from '@/mixins/dialogMixin'
import { allRole } from '@/api/role'
import { getRoles, grantRolesToUser } from '@/api/user'
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
      allRoles: [],
      roles: []
    }
  },
  mounted() {
    if (this.targetId !== 0) {
      // todo 获取用户当前角色值
      this.getAllRoles()
      this.getUserRoles(this.targetId)
    }
  },

  methods: {
    async getUserRoles(userId) {
      const res = await getRoles(userId)
      res.data.forEach(role => {
        this.roles.push(role.id)
      })
    },

    async getAllRoles() {
      const res = await allRole()
      res.data.forEach(role => {
        this.allRoles.push({
          key: role.id,
          label: role.name,
          disabled: role.status === 0
        })
      })
    },

    submit() {
      grantRolesToUser(this.targetId, this.roles).then(res => {
        this.$message.success('赋角成功')
        this.show = false
      })
    }
  }
}
</script>
