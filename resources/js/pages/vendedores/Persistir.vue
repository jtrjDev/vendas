<script setup lang="ts">
import { Form, Head, router, useForm, usePage } from '@inertiajs/vue3';
//import { vMaska } from 'maska/vue';
import { onMounted } from 'vue';
//import { toast } from 'vue-sonner';

import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import vendedores from '@/routes/vendedores';

const page = usePage();
const props = page.props as unknown as {
    idVendedor: number | null;
    vendedor?: Record<string, any>;
};

const vendedor = props.vendedor;

// checa explicitamente null/undefined e mostra erro


</script>

<template>
    <Head title="Vendedor" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Vendedores" description="Cria vendedores" />

            <div class="md:grid-cols 4 grid-cols-1">
                <div class="relative min-h-screen flex-1 rounded-xl border p-4">

                    <Form>
                        <Heading title="Informações pessoais" />

                        <div class="mb-4 grid grid-cols-1 gap-6 md:grid-cols-3">

                            <!-- NOME -->
                            <div class="grid gap-2">
                                <Label for="nome">Nome</Label>
                                <!--
                                <Input
                                    id="nome"
                                    v-model="form.nome"
                                    type="text"
                                />
                                -->
                                <Input
                                    id="nome"
                                    type="text"
                                    placeholder="Nome completo"
                                />
                                <!-- <InputError :message="form.errors.nome" /> -->
                            </div>

                            <!-- EMAIL -->
                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <!--
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                />
                                -->
                                <Input
                                    id="email"
                                    type="email"
                                    placeholder="email@exemplo.com"
                                />
                                <!-- <InputError :message="form.errors.email" /> -->
                            </div>

                            <!-- CPF -->
                            <div class="grid gap-2">
                                <Label for="cpf">CPF</Label>
                                <!--
                                <Input
                                    id="cpf"
                                    v-model="form.cpf"
                                    type="text"
                                    v-maska="'###.###.###-##'"
                                />
                                -->
                                <Input
                                    id="cpf"
                                    type="text"
                                    placeholder="000.000.000-00"
                                />
                                <!-- <InputError :message="form.errors.cpf" /> -->
                            </div>

                        </div>

                        <Separator />
                        <Heading title="Informações adicionais" class="mt-4" />

                        <!-- COMISSÃO -->
                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="grid gap-2">
                                <Label for="comissao">Comissão</Label>
                                <!--
                                <Input
                                    id="comissao"
                                    v-model="form.comissao"
                                />
                                -->
                                <Input
                                    id="comissao"
                                    type="text"
                                    placeholder="0.0%"
                                />
                                <!-- <InputError :message="form.errors.comissao" /> -->
                            </div>
                        </div>

                        <Separator />
                        <Heading title="Endereço" class="mt-4" />

                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-3">

                            <!-- CEP -->
                            <div class="grid gap-2">
                                <Label for="cep">CEP</Label>
                                <!--
                                <Input
                                    id="cep"
                                    v-model="form.cep"
                                />
                                -->
                                <Input
                                    id="cep"
                                    type="text"
                                    placeholder="00000-000"
                                />
                                <!-- <InputError :message="form.errors.cep" /> -->
                            </div>

                            <!-- RUA -->
                            <div class="grid gap-2">
                                <Label for="rua">Rua</Label>
                                <!--
                                <Input
                                    id="rua"
                                    v-model="form.rua"
                                />
                                -->
                                <Input
                                    id="rua"
                                    type="text"
                                    placeholder="Rua"
                                />
                            </div>

                            <!-- NUMERO -->
                            <div class="grid gap-2">
                                <Label for="numero">Número</Label>
                                <!--
                                <Input
                                    id="numero"
                                    v-model="form.numero"
                                />
                                -->
                                <Input
                                    id="numero"
                                    type="text"
                                    placeholder="Número"
                                />
                            </div>

                            <!-- COMPLEMENTO -->
                            <div class="grid gap-2">
                                <Label for="complemento">Complemento</Label>
                                <!--
                                <Input
                                    id="complemento"
                                    v-model="form.complemento"
                                />
                                -->
                                <Input
                                    id="complemento"
                                    type="text"
                                    placeholder="Complemento"
                                />
                            </div>

                            <!-- BAIRRO -->
                            <div class="grid gap-2">
                                <Label for="bairro">Bairro</Label>
                                <!--
                                <Input
                                    id="bairro"
                                    v-model="form.bairro"
                                />
                                -->
                                <Input
                                    id="bairro"
                                    type="text"
                                    placeholder="Bairro"
                                />
                            </div>

                            <!-- CIDADE -->
                            <div class="grid gap-2">
                                <Label for="cidade">Cidade</Label>
                                <!--
                                <Input
                                    id="cidade"
                                    v-model="form.cidade"
                                />
                                -->
                                <Input
                                    id="cidade"
                                    type="text"
                                    placeholder="Cidade"
                                />
                            </div>

                            <!-- ESTADO -->
                            <div class="grid gap-2">
                                <Label for="estado">Estado</Label>
                                <!--
                                <Input
                                    id="estado"
                                    v-model="form.estado"
                                />
                                -->
                                <Input
                                    id="estado"
                                    type="text"
                                    placeholder="UF"
                                />
                            </div>

                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-5">
                            <Button type="submit" class="mt-2 w-full">
                                Salvar Vendedor
                            </Button>
                        </div>

                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<style scoped></style>