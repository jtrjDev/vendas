<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

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

// props do Inertia (reativo)
const page = usePage();

const produtos = computed(() => page.props.produtos as Array<{
    id: number;
    nome: string;
    valor: number;
}>);

// produto selecionado para edição
const produtoSelecionado = ref<{
    id: number;
    nome: string;
    valor: number;
} | null>(null);
</script>

<template>
    <Head title="Produtos" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <Heading title="Produtos" description="Lista de produtos" />

            <!-- Botão criar -->
            <ButtonCriarProduto
                :produto="produtoSelecionado"
                @fechar="produtoSelecionado = null"
            />

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
                        <TableRow
                            v-for="produto in produtos"
                            :key="produto.id"
                        >
                            <TableCell>{{ produto.nome }}</TableCell>

                            <TableCell class="flex gap-2">
                                <Button
                                    @click="produtoSelecionado = produto"
                                >
                                    Editar
                                </Button>
                                <Button>
                                    Remover
                                </Button>
                            </TableCell>
                        </TableRow>

                        <TableRow v-if="produtos.length === 0">
                            <TableCell colspan="2" class="text-center">
                                Nenhum produto cadastrado
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
