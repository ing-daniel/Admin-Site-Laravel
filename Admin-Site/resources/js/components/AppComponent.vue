<template>
    <a-layout id="components-layout-demo-top" class="layout" style="min-height:100vh">
        <a-layout-header>
            <div class="logo" />
            <a-menu
                theme="dark"
                mode="horizontal"
                :defaultSelectedKeys="['2']"
                :style="{ lineHeight: '64px' }"
            >
               <a-sub-menu>
                    <span slot="title" class="submenu-title-wrapper"><a-icon type="user" />Personas</span>
                    <a-menu-item key="setting:1">
                        <router-link :to="'/'">Lista de Personas</router-link>
                    </a-menu-item>
                    <a-menu-item key="setting:2">
                        <router-link :to="'/persona'">Nueva Personas</router-link>
                    </a-menu-item>
                </a-sub-menu>
            </a-menu>
        </a-layout-header>
    <a-layout-content style="padding: 0 50px">
      <div :style="{ background: '#fff', padding: '24px', minHeight: '280px', margin: '16px 0' }">
            <transition name="slide-fade" mode="out-in">
                <router-view></router-view>
            </transition>
      </div>
    </a-layout-content>
    <a-layout-footer style="text-align: center">
      Admin Site - Daniel Pérez Cabrera
    </a-layout-footer>
  </a-layout>
</template>

<style>
    #components-layout-demo-top .logo {
    width: 120px;
    height: 31px;
    background: rgba(255,255,255,.2);
    margin: 16px 24px 16px 0;
    float: left;
    }
</style>