<template>
  <el-dialog title="" :visible.sync="show" :close-on-click-modal="false" @close="closeDialog">
    <el-transfer v-model="permissions" :data="allPermission" :titles="['所有权限', '已有权限']" filterable />
    <el-button type="success" style="margin-top: 10px;" @click="submit">提 交</el-button>
  </el-dialog>
</template>

<script>
import dialogMixin from '@/mixins/dialogMixin'
import { allPermission } from '@/api/permission'
import { getPermissions, grantPermissionsToRole } from '@/api/role'
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
      allPermission: [],
      permissions: []
    }
  },
  mounted() {
    if (this.targetId !== 0) {
      this.getAllPermission()

      this.getRolePermissions(this.targetId)
    }
  },
  methods: {
    async getAllPermission() {
      const res = await allPermission()
      res.data.forEach(permission => {
        this.allPermission.push({
          key: permission.id,
          label: permission.name
        })
      })
    },

    async getRolePermissions(id) {
      const res = await getPermissions(id)
      res.data.forEach(permission => {
        this.permissions.push(permission.id)
      })
    },

    submit() {
      grantPermissionsToRole(this.targetId, this.permissions).then(res => {
        this.$message.success('授权成功')
        this.show = false
      })
    }
  }
}
</script>
