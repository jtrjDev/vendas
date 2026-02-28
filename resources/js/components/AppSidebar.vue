<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Box, Folder, LayoutGrid, ShoppingCart, User, Users } from 'lucide-vue-next';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import AppLogo from './AppLogo.vue';
import vendedores from '@/routes/vendedores';
import clientes from '@/routes/clientes';
import produtos from '@/routes/produtos';
import vendas from '@/routes/vendas';
import { computed } from 'vue';

const page = usePage();

const roleUser = computed(() => (page.props as any).auth?.roleName ?? null);
const mainNavItems = [

    {
        title: 'Vendedores',
        href: vendedores.listar(),
        icon: User,
        permission: ['admin'],
    },
    {
        title: 'Clientes',
        href: clientes.listar(),
        icon: Users,
        permission: ['admin'],
    },
    {
        title: 'Produtos',
        href: produtos.listar(),
        icon: Box,
        permission: ['admin'],
    },
    {
        title: 'Vendas',
        href: vendas.listar(),
        icon: ShoppingCart,
    },
];

function hasAcess(item: any) {
    if (!item.permission) return true;
    if (!roleUser.value) return false;


    if (item.permission.includes(roleUser.value)) {

        return true;
    }
    return false;
}
const filteredNavItems = computed(()=> mainNavItems.filter(hasAcess));

const footerNavItems: NavItem[] = [
    /*  {
         title: 'Github Repo',
         href: 'https://github.com/laravel/vue-starter-kit',
         icon: Folder,
     },
     {
         title: 'Documentation',
         href: 'https://laravel.com/docs/starter-kits#vue',
         icon: BookOpen,
     }, */
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="filteredNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
