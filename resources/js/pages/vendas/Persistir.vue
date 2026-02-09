<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    Select,
    SelectContent,
    SelectValue,
    SelectItem,
    SelectTrigger,
} from '@/components/ui/select';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
</script>
<template>

    <Head title="Vendas" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Vendas" description="Realizar venda" />

            <div class="relative flex-1 rounded-xl border p-4">

                <!-- DADOS DA VENDA -->
                <Heading title="Dados da venda" />

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- CLIENTE -->
                    <div class="flex flex-col gap-1">
                        <Label for="cliente">Cliente</Label>
                        <Select class="w-full">
                            <SelectTrigger class="h-10 w-full" >
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

                    <!-- VENDEDOR -->
                    <div class="flex flex-col gap-1">
                        <Label for="vendedor">Vendedor</Label>
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

                </div>


                <Separator class="my-8" />

                <!-- ITENS DA VENDA -->
                <Heading title="Itens da venda" class="mt-6" />

                <div class="mt-6 flex gap-4">
                    <Button type="button">
                        Adicionar itens
                    </Button>
                </div>

                <Separator class="my-8" />

                <!-- AÇÃO FINAL -->
                <div class="mt-6 flex justify-center">
                    <Button type="submit" class="bg-green-400 dark:bg-green-500 dark:hover:bg-green-500/90" tabindex="5"
                        data-test="register-user-button">
                        Gravar venda
                    </Button>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
