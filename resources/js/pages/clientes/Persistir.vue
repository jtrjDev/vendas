<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
</script>


<template>

    <Head title="Cliente" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Clientes" description="Criar cliente" />

            <div class="relative flex-1 rounded-xl border p-4">

                <!-- DADOS DO CLIENTE -->
                <Heading title="Informações do cliente" />

                <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-3">

                    <!-- NOME -->
                    <div class="grid gap-2">
                        <Label for="nome">Nome</Label>
                        <!--
                        <Input id="nome" v-model="form.nome" />
                        -->
                        <Input id="nome" type="text" placeholder="Nome completo" />
                    </div>

                    <!-- EMAIL -->
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <!--
                        <Input id="email" v-model="form.email" />
                        -->
                        <Input id="email" type="email" placeholder="email@exemplo.com" />
                    </div>

                    <!-- CPF -->
                    <div class="grid gap-2">
                        <Label for="cpf">CPF</Label>
                        <!--
                        <Input id="cpf" v-model="form.cpf" />
                        -->
                        <Input id="cpf" type="text" placeholder="000.000.000-00" />
                    </div>

                </div>

                <Separator class="my-8" />

                <!-- ENDEREÇO -->
                <Heading title="Endereço" class="mt-6" />

                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-3">


                    <!-- RUA -->
                    <div class="grid gap-2 md:col-span-2">
                        <Label for="rua">Rua</Label>
                        <!--
                        <Input id="rua" v-model="form.rua" />
                        -->
                        <Input id="rua" type="text" placeholder="Rua" />
                    </div>

                    <!-- NÚMERO -->
                    <div class="grid gap-2">
                        <Label for="numero">Número</Label>
                        <!--
                        <Input id="numero" v-model="form.numero" />
                        -->
                        <Input id="numero" type="text" placeholder="Número" />
                    </div>

                    <!-- COMPLEMENTO -->
                    <div class="grid gap-2">
                        <Label for="complemento">Complemento</Label>
                        <!--
                        <Input id="complemento" v-model="form.complemento" />
                        -->
                        <Input id="complemento" type="text" placeholder="Complemento" />
                    </div>

                    <!-- CIDADE -->
                    <div class="grid gap-2">
                        <Label for="cidade">Cidade</Label>
                        <!--
                        <Input id="cidade" v-model="form.cidade" />
                        -->
                        <Input id="cidade" type="text" placeholder="Cidade" />
                    </div>

                    <!-- ESTADO -->
                    <div class="grid gap-2">
                        <Label for="estado">Estado</Label>
                        <!--
                        <Input id="estado" v-model="form.estado" />
                        -->
                        <Input id="estado" type="text" placeholder="UF" />
                    </div>

                </div>

                <div class="mt-6">
                    <Button type="submit">
                        Salvar Cliente
                    </Button>
                </div>

            </div>
        </div>
    </AppLayout>
</template>




<style scoped></style>