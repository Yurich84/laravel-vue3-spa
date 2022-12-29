<template>
    <div class="app">
        <router-view
            :key="$route.fullPath"
            v-slot="{ Component }"
        >
            <div
                v-if="!$auth.ready()"
                class="loading-screen"
            >
                <div class="loading-text">
                    <p>Loading ...</p>
                </div>
            </div>
            <component
                :is="Component"
                v-if="$auth.ready()"
            />
        </router-view>
    </div>
</template>

<style lang="scss">
.app {
    > div.loading-screen {
        height: 100vh;

        > .loading-text {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);

            > p {
                text-shadow: 1px 1px 3px #000000;
                font-size: calc(3vh + 2vw);
                color: #ffffff;
            }
        }
    }
}
</style>
