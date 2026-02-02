<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

</script>

<template>
    <Head title="Vendedor" />

    <AppLayout>
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Heading title="Vendedores" description="Lista de vendedores" />
            <div class="md:grid-cols 4 grid-cols-1">
                <Link>
                    <Button class="bg-black dark:bg-white">
                        <Icon name="plus" />
                        Criar Novo Vendedor
                    </Button>
                </Link>
            </div>

            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                                <!--<Table v-if="vendedoresList.length > 0">-->
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead> Nome </TableHead>
                                            <TableHead>Email</TableHead>
                                            <TableHead>CPF</TableHead>
                                            <TableHead> Acoes </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow>
                                            <TableCell>Nome de teste</TableCell>
                                            <TableCell>Email Teste</TableCell>
                                            <TableCell>CPF</TableCell>
                                            <TableCell>
                                                <Button>
                                                    Remover
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                        
                                    </TableBody>
                                </Table>
            </div>
        </div>
    </AppLayout>
</template>