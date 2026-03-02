<script setup lang="ts">
import { Form, Head, useForm, usePage } from '@inertiajs/vue3'
import { toast } from 'vue-sonner'
import { computed } from 'vue'

import Heading from '@/components/Heading.vue'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Separator } from '@/components/ui/separator'
import AppLayout from '@/layouts/AppLayout.vue'
import vendas from '@/routes/vendas'

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
import ButtonAdicionarItemVenda from '@/components/vendas/ButtonAdicionarItemVenda.vue';
import { ref } from 'vue';

const itens = ref<any[]>([])
</script>

<template>
    <Head title="Venda" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Venda" description="Realizar venda" />

            <div class="relative flex-1 rounded-xl border p-6">

                <Form @submit.prevent="enviar">

                    <!-- DADOS -->
                    <Heading title="Dados da venda" />

                    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">

                        <!-- CLIENTE -->
                        <div class="grid gap-2">
                            <Label>Cliente</Label>
                            <Select v-model="form.id_cliente">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecione o cliente" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="cliente in clientes"
                                        :key="cliente.id"
                                        :value="cliente.id"
                                    >
                                        {{ cliente.nome }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.id_cliente" />
                        </div>

                        <!-- VENDEDOR -->
                        <div class="grid gap-2">
                            <Label>Vendedor</Label>
                            <Select v-model="form.id_vendedor">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecione o vendedor" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="vendedor in vendedores"
                                        :key="vendedor.id_vendedor"
                                        :value="vendedor.id_vendedor"
                                    >
                                        {{ vendedor.user.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.id_vendedor" />
                        </div>
                    </div>

                    <Separator class="my-8" />

                    <!-- ITENS -->
                    <Heading title="Itens da venda" />

                <div class="mt-6 flex gap-4">
                   <ButtonAdicionarItemVenda
                    :produtos="produtos"
                    @adicionar="(item) => itens.push(item)"
                    />
                </div>

                    <Separator class="my-8" />

                    <!-- BOTÃO -->
                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="mt-2 w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold"
                    >
                        Salvar Venda
                    </Button>

                </Form>

            </div>
        </div>
    </AppLayout>
</template>