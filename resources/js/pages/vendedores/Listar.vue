<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AcoesTabelaVendedor from '@/components/Vendedores/AcoesTabelaVendedor.vue';  // Ajuste o caminho conforme necessário

import AppLayout from '@/layouts/AppLayout.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import vendedores from '@/routes/vendedores';
import { computed } from 'vue';
import { Helper } from '@/Utils/Helper';

type Vendedor = Record<string, any>;

const page = usePage();

const vendedoresList = computed<Vendedor[]>(()=>{
    return page.props.vendedores ?? [];
})

console.log(vendedoresList);

</script>

<template>

    <Head title="Vendedor" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Vendedores" description="Lista de vendedores" />
            <div class="md:grid-cols 4 grid-cols-1">
                <Link :href="vendedores.persistir()">
                    <Button class="bg-black dark:bg-white">
                        <Icon name="plus" />
                        Criar Novo Vendedor
                    </Button>
                </Link>
            </div>

            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border">
                <!--<Table v-if="vendedoresList.length > 0">-->
                <Table v-if="vendedoresList.length >0">
                    <TableHeader>
                        <TableRow>
                            <TableHead> Nome </TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>CPF</TableHead>
                            <TableHead> Acoes </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                          v-for="vendedor in vendedoresList"
                          :key="vendedor.id_vendedor"
                        >
                            <TableCell>{{ vendedor.user.name }}</TableCell>
                            <TableCell>{{ vendedor.user.email }}</TableCell>
                            <TableCell>{{ Helper.formatarCPF(vendedor.cpf) }}</TableCell>
                            <TableCell>
                               <AcoesTabelaVendedor :vendedor="vendedor"/>

                            </TableCell>
                        </TableRow>

                    </TableBody>
                </Table>
                <div
                    class="flex h-full w-full flex-col items-center justify-center gap-4"
                    v-else
                
                >

                <Icon
                    name="users"
                    class="h-16 w-16 text-muted-foreground"
                />

                <p class="text-center text-muted-foreground">
                    Nenhum vendedor encontrado.

                </p>

                </div>
            </div>
        </div>
    </AppLayout>
</template>