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
import ButtonCriarProduto from '@/components/produtos/ButtonCriarProduto.vue';
</script>
<template>

    <Head title="Produtos" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Produtos" description="Lista de produtos" />
            <!-- Botão nova venda -->
            <div class="md:grid-cols 4 grid-cols-1">
                <ButtonCriarProduto />


            </div>

            <!-- Tabela -->
            <div class="relative flex-1 rounded-xl border p-4">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100%]">Nome</TableHead>
                            <TableHead>Ações</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <!-- Venda fictícia 1 -->
                        <TableRow>
                            <TableCell>Sorvete Self-Serv</TableCell>
                            <TableCell class="flex gap-2">
                                <Button>
                                    Editar
                                </Button>
                                <Button>
                                    Remover
                                </Button>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Picolé de frutas</TableCell>
                            <TableCell class="flex gap-2">
                                <Button>
                                    Editar
                                </Button>
                                <Button>
                                    Remover
                                </Button>
                            </TableCell>
                        </TableRow>

                        <!-- Venda fictícia 2 -->

                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
