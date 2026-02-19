<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogTrigger, DialogClose, } from '@/components/ui/dialog';
import clientes from '@/routes/clientes';

const props = defineProps<{
    cliente: Record<string, any>;
}>();

const cliente = props.cliente;

function removeCliente(){
    router.delete(clientes.remove(cliente.id_cliente),{
        onSuccess: () => {
            console.log('success');
            
        },
        onError: (errors) =>{
            console.log(errors);
            
        }
    })
}


</script>

<template>
    <div class="flex gap-2">
        <Link :href="clientes.persistir(cliente.id_cliente)">
            <Button class="bg-yellow-400 dark:bg-white">
                <!--<Button class="bg-accent  hover:bg-accent/90">-->
                <Icon name="plus" />
                Editar cliente
            </Button>
        </Link>
        <Dialog>
            <DialogTrigger>
                <Button class="bg-red-700 hover:bg-red-700/90">
                    <span>Remover</span>
                </Button>
            </DialogTrigger>
            <DialogContent>
                <span>
                    Tem certeza que deseja remover o cliente:
                    {{ cliente.nome }}?
                </span>
                <div class="flex justify-end gap-2">

                    <Button class="bg-red-700 hover:bg-red-700/90 text-white" @click="removeCliente">
                        Remover Cliente
                    </Button>
                    <DialogClose>
                        <Button>
                            Cancelar
                        </Button>
                    </DialogClose>
                </div>
            </DialogContent>
        </Dialog>

    </div>
</template>
<style scoped></style>