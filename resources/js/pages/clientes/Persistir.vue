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
                <Heading title="Informações do cliente" />

                <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-3">

                    <!-- NOME -->
                    <div class="grid gap-2">
                        <Label for="nome">Nome</Label>
                        <!--
                        <Input
                            id="nome"
                            v-model="form.nome"
                        />
                        -->
                        <Input
                            id="nome"
                            type="text"
                            placeholder="Nome completo"
                        />
                    </div>

                    <!-- EMAIL -->
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <!--
                        <Input
                            id="email"
                            v-model="form.email"
                        />
                        -->
                        <Input
                            id="email"
                            type="email"
                            placeholder="email@exemplo.com"
                        />
                    </div>

                    <!-- CPF -->
                    <div class="grid gap-2">
                        <Label for="cpf">CPF</Label>
                        <!--
                        <Input
                            id="cpf"
                            v-model="form.cpf"
                        />
                        -->
                        <Input
                            id="cpf"
                            type="text"
                            placeholder="000.000.000-00"
                        />
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