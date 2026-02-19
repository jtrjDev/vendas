<script setup lang="ts">
import { Form, Head, router, useForm, usePage } from '@inertiajs/vue3';

import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import clientes from '@/routes/clientes';
import { onMounted } from 'vue';

const page = usePage();

const props = page.props as unknown as {
    idCliente?: number | null;
    cliente?: Record<string, any>;
}

const cliente = props.cliente;
const idCliente = props.idCliente;


 onMounted(()=>{
        if (props.idCliente != null && !cliente){
            router.visit(clientes.listar().url);
            //toast.error('Vendedor não encontrado');
        }
    });


const form = useForm({
    id_cliente: idCliente ?? null,
    nome: cliente?.nome ?? '',
    email: cliente?.email ?? '',
    cpf: cliente?.cpf ?? '',
    cep: cliente?.endereco?.cep ?? '',
    rua: cliente?.endereco?.rua ?? '',
    numero: cliente?.endereco?.numero ?? '',
    complemento: cliente?.endereco?.complemento ?? '',
    bairro: cliente?.endereco?.bairro ?? '',
    cidade: cliente?.endereco?.cidade ?? '',
    estado: cliente?.endereco?.estado ?? '',

});


function viaCepLookup(cep: string) {
    cep = cep.replace(/\D/g, ''); // Remove non-digit characters
    fetch(`https://viacep.com.br/ws/${cep}/json/`)  // Usando crase para interpolação
        .then((response) => response.json())
        .then((data) => {
            form.rua = data.logradouro || '';
            form.bairro = data.bairro || '';
            form.cidade = data.localidade || '';
            form.estado = data.uf || '';
        })
        .catch((error) => {
            console.error('Erro ao buscar CEP:', error);
        });
}

function enviar() {
    // console.log(form);
    // return;
    if (idCliente !== null) {
        form.put(clientes.update(idCliente).url,{
            onSuccess: () => {
                    console.log('success');
                },
                onError: () => {
                    console.log('erro');
                    
                } 
        })

        return;
    }

    form.post(clientes.create().url, {
        onSuccess: () => {
            console.log('success');
        },
        onError: () => {
            console.log(form.errors);
        },
    });

}


</script>


<template>

    <Head title="Cliente" />

    <AppLayout>
            <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Heading title="Vendedores" description="Criar vendedores" />
                <div class="md:grid-cols 4 grid-cols-1">
                    <div
                        class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border">
                        <Form @submit.prevent="enviar">
                            <!-- <Form @submit.prevent="submit"> -->
                            <Heading title="Informações pessoais" />

                            <div class="mb-4 grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div class="grid gap-2">
                                    <Label for="nome">Nome</Label>
                                    <Input v-model="form.nome" id="nome" type="text" autofocus :tabindex="1"
                                        autocomplete="nome" name="nome" placeholder="Nome Completo" />
                                    <InputError :message="form.errors.nome" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="email">Email</Label>
                                    <Input id="email" v-model="form.email" type="email" :tabindex="2" autocomplete="email"
                                        name="email" placeholder="email@exemplo.com" />
                                    <InputError :message="form.errors.email" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="cpf">CPF</Label>
                                    <Input v-model="form.cpf" id="cpf" type="text" :tabindex="2" autocomplete="cpf"
                                        name="cpf" placeholder="000.000.000-00" v-maska="'###.###.###-##'" />
                                    <InputError :message="form.errors.cpf" />
                                </div>
                            </div>
                           
                            <Heading title="Endereço" class="mt-4" />
                            <div class="mt-4 mb-4 grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div class="grid gap-2">
                                    <Label for="cep">CEP</Label>
                                    <Input v-model="form.cep" id="cep" type="text" :tabindex="2" autocomplete="cep"
                                        name="cep" placeholder="insira seu CEP" @blur="viaCepLookup(form.cep)" />
                                    <InputError :message="form.errors.cep" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="rua">Rua</Label>
                                    <Input v-model="form.rua" id="rua" type="text" :tabindex="2" autocomplete="rua"
                                        name="rua" placeholder="Insira sua rua" />
                                    <InputError :message="form.errors.rua" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="numero">Número</Label>
                                    <Input v-model="form.numero" id="numero" type="text" :tabindex="2" autocomplete="numero"
                                        name="numero" placeholder="Insira sua número" />
                                    <InputError :message="form.errors.numero" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="complemento">Complemento</Label>
                                    <Input v-model="form.complemento" id="complemento" type="text" :tabindex="2"
                                        autocomplete="complemento" name="complemento"
                                        placeholder="Insira sua complemento" />
                                    <InputError :message="form.errors.complemento" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="bairro">Bairro</Label>
                                    <Input v-model="form.bairro" id="bairro" type="text" :tabindex="2" autocomplete="bairro"
                                        name="bairro" placeholder="Insira sua bairro" />
                                    <InputError :message="form.errors.bairro" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="cidade">Cidade</Label>
                                    <Input v-model="form.cidade" id="cidade" type="text" :tabindex="2" autocomplete="cidade"
                                        name="cidade" placeholder="Insira sua cidade" />
                                    <InputError :message="form.errors.cidade" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="estado">Estado</Label>
                                    <Input v-model="form.estado" id="estado" type="text" :tabindex="2" autocomplete="estado"
                                        name="estado" placeholder="Insira sua estado" />
                                    <InputError :message="form.errors.estado" />
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-5">
                                <Button type="submit"
                                    class="mt-2 w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold"
                                    tabindex="5" data-test="register-user-button">
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