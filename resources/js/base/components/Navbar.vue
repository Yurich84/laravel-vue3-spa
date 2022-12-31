<template>
    <el-header class="header">
        <div
            class="logo"
            :class="coreIsCollapsed?'logo-collapse-width':'logo-width'"
        >
            {{ coreIsCollapsed ? '' : $config.appName }}
        </div>
        <div class="tools">
            <div @click.prevent="collapse">
                <i class="fa fa-align-justify" />
            </div>
        </div>
        <div
            class="userinfo"
        >
            <span>{{ sysUserName }}</span>
            <el-dropdown>
                <span class="el-dropdown-link userinfo-inner">
                    <img :src="sysUserAvatar">
                </span>
                <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item
                            divided
                            @click.native="logout"
                        >
                            {{ $t('auth.logout.title') }}
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
    </el-header>
</template>

<script>
export default {
    data: () => ({
        sysUserName: '',
        sysUserAvatar: '',
    }),
    methods: {
        logout: function () {
            this.$confirm(this.$t('auth.logout_confirm.text').toString(), this.$t('auth.logout_confirm.title').toString(), {
                confirmButtonText: this.$t('auth.logout_confirm.button_ok').toString(),
                cancelButtonText: this.$t('auth.logout_confirm.button_cancel').toString(),
            }).then(() => {
                this.$auth.logout()
            })
        },
        collapse() {
            // todo
        },
    },
    mounted() {
        const user = this.$auth.user()
        if (user) {
            this.sysUserName = user.name || ''
            this.sysUserAvatar = user.avatar || ''
        }
    },
    computed: {
        coreIsCollapsed() {
            return false
        }
    }
}
</script>

<style lang="scss">
.header {
    height: 60px;
    line-height: 60px;
    background: #20a0ff;
    color: #fff;
    --el-header-padding: 0px !important;

    .logo {
        float: left;
        height: 60px;
        font-size: 22px;
        padding:0 20px;
        border-color: rgba(238, 241, 146, 0.3);
        border-right-width: 1px;
        border-right-style: solid;
    }

    .logo-width {
        width: 190px;
    }

    .logo-collapse-width {
        width: 65px
    }

    .tools {
        float: left;
        div {
            padding: 0 23px;
            width: 14px;
            height: 60px;
            line-height: 60px;
            cursor: pointer;
        }
    }

    .userinfo {
        float: right;
        text-align: right;
        padding-right: 35px;
        .userinfo-inner {
            cursor: pointer;
            color: #fff;

            img {
                width: 40px;
                height: 40px;
                border-radius: 20px;
                margin: 10px 0 10px 10px;
                float: right;
            }
        }
    }
}
</style>
