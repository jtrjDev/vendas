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
} from '@/components/ui/table';
</script>


<template>
    <Head title="Clientes" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Clientes" description="Lista de clientes" />

            <div class="flex justify-end">
                <Link href="/clientes/persistir">
                    <Button>
                        Criar Novo Cliente
                    </Button>
                </Link>
            </div>

            <div class="relative flex-1 rounded-xl border p-4">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nome</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>CPF</TableHead>
                            <TableHead>Ações</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <!-- Linha de exemplo (estática, didática) -->
                        <TableRow>
                            <TableCell>Cliente Teste</TableCell>
                            <TableCell>cliente@teste.com</TableCell>
                            <TableCell>000.000.000-00</TableCell>
                            <TableCell>
                                <Button variant="destructive">
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
