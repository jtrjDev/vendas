<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectValue,
    SelectItem,
    SelectTrigger,
} from '@/components/ui/select';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
const page = usePage();
const props = page.props as unknown as {
    idVendedor: number | null;
    vendedor?: Record<string, any>;
}
import { Head, Link, usePage } from '@inertiajs/vue3';

import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';

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

    <Head title="Vendas" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Vendas" description="Lista de vendas realizadas" />

            <!-- Botão nova venda -->
            <div class="flex justify-end">
                <Link href="/vendas/persistir">
                    <Button>
                        Nova Venda
                    </Button>
                </Link>
            </div>

            <!-- Filtro Vendedor -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

                <!-- FILTRO VENDEDOR -->
                <div class="flex flex-col gap-1">
                    <Label>Vendedor</Label>
                    <Select class="w-full">
                        <SelectTrigger class="h-10 w-full">
                            <SelectValue placeholder="Selecione o vendedor" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem :value="null">
                                Todos os vendedores
                            </SelectItem>
                            <SelectItem :value="1">
                                Vendedor 1
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <!-- FILTRO CLIENTE -->
                <div class="flex flex-col gap-1">
                    <Label>Cliente</Label>
                    <Select class="w-full">
                        <SelectTrigger class="h-10 w-full">
                            <SelectValue placeholder="Selecione o cliente" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem :value="null">
                                Todos os clientes
                            </SelectItem>
                            <SelectItem :value="1">
                                Cliente 1
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

            </div>


            <!-- Tabela -->
            <div class="relative flex-1 rounded-xl border p-4">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Cliente</TableHead>
                            <TableHead>Vendedor</TableHead>
                            <TableHead>Valor</TableHead>
                            <TableHead>Comissão</TableHead>
                            <TableHead>Ações</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <!-- Venda fictícia 1 -->
                        <TableRow>
                            <TableCell>Maria Silva</TableCell>
                            <TableCell>João Santos</TableCell>
                            <TableCell>R$ 1.200,00</TableCell>
                            <TableCell>R$ 120,00</TableCell>
                            <TableCell class="flex gap-2">
                                <Button>
                                    Editar
                                </Button>
                                <Button>
                                    Remover
                                </Button>
                                <Button>
                                    Excel
                                </Button>
                                <Button>
                                    PDF
                                </Button>
                            </TableCell>
                        </TableRow>

                        <!-- Venda fictícia 2 -->
                        <TableRow>
                            <TableCell>Carlos Pereira</TableCell>
                            <TableCell>Ana Oliveira</TableCell>
                            <TableCell>R$ 850,00</TableCell>
                            <TableCell>R$ 85,00</TableCell>
                            <TableCell class="flex gap-2">
                                <Button>
                                    Editar
                                </Button>
                                <Button>
                                    Remover
                                </Button>
                                <Button>
                                    Excel
                                </Button>
                                <Button>
                                    PDF
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
